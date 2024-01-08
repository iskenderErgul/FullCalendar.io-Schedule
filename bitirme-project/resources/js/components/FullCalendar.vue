<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <form @submit.prevent>
                    <div class="form-group mb-1">
                        <label for="event_name">Etkinlik Adı</label>
                        <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name">
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Başlangıç Tarihi</label>
                                <input
                                    type="date"
                                    id="start_date"
                                    class="form-control"
                                    v-model="newEvent.start_date"
                                >
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="end_date">Bitiş Tarihi</label>
                                <input type="date" id="end_date" class="form-control" v-model="newEvent.end_date">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4" v-if="addingMode">
                            <button class="btn btn-sm btn-primary" @click="addNewEvent">Kaydet</button>
                        </div>
                        <template v-else>
                            <div class="col-md-6 mb-4">
                                <button class="btn btn-sm btn-success" @click="updateEvent">Güncelle</button>
                                <button class="btn btn-sm btn-danger" @click="deleteEvent">Sil</button>
                                <button class="btn btn-sm btn-secondary" @click="toggleAddingMode">İptal</button>
                            </div>
                        </template>
                    </div>
                </form>
            </div>
            <div class="col-md-8 w-75 h-75 ">

                <FullCalendar @eventClick="showEvent"   :options="calendarOptions" />
            </div>
        </div>
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import axios from "axios";
import { format } from 'date-fns';

export default {
    components: {
        FullCalendar
    },
    data() {
        return {
            calendarOptions: {
                plugins: [ dayGridPlugin, interactionPlugin ],
                initialView: 'dayGridMonth',
                events: [],
                dateClick: this.showEvent,
                eventClick: this.showEvent,
                locale : 'tr' ,
                editable : true,
                droppable: true,
                eventDrop: this.handleEventDrop,
                eventResize: this.eventResize



            },
            newEvent: {
                event_name: "",
                start_date: "",
                end_date: ""
            },
            addingMode: true,
            indexToUpdate: ""
        };
    },
    mounted() {
        this.getEvents();
    },
    methods: {
        
        handleEventDrop(info) {
            console.log(info);
            const droppedEvent = info.event;
            const defId = droppedEvent._def.publicId;
            const title = droppedEvent._def.title;
            const start = format(new Date(droppedEvent.start), 'yyyy-MM-dd');
            const end = format(new Date(droppedEvent.end), 'yyyy-MM-dd');

            console.log(title);
            console.log(start);
            console.log(end);

            axios
                .put(`/api/calendar/${defId}`, {
                    event_name: title,
                    start_date: start,
                    end_date: end,
                })
                .then(resp => {
                    console.log("Sürükleme İşlemi Başarılı!!!");
                })
                .catch(err => {
                    console.log("Sürükleme İşlemi Başarısız!!!!", err.response.data);
                });
        },
        eventResize(info) {
            const resizedEvent = info.event;
            const defId = resizedEvent._def.publicId;
            const start = format(new Date(resizedEvent.start), 'yyyy-MM-dd');
            const end = format(new Date(resizedEvent.end), 'yyyy-MM-dd');

            axios
                .put(`/api/calendar/${defId}`, {
                    start_date: start,
                    end_date: end,
                })
                .then(resp => {
                    console.log("Etkinlik Süresi Güncelleme Başarılı!");
                    // Takvimi güncelle
                    this.getEvents();
                })
                .catch(err => {
                    console.log("Etkinlik Süresi Güncelleme Başarısız!", err.response.data);
                });
        },

        addNewEvent() {
            axios
                .post("/api/calendar", {
                    ...this.newEvent
                })
                .then(data => {
                    this.getEvents();
                    this.resetForm();
                })
                .catch(err =>
                    alert("Ekleme işlemi Başarısız! Lütfen Tüm alanları Doldurun!!", err.response.data)
                );
        },
        showEvent(arg) {

            if (arg.event && arg.event.id) {
                const clickedEvent = this.calendarOptions.events.find(
                    event => event.id === +arg.event.id
                );

                if (clickedEvent) {
                    this.addingMode = false;
                    const { id, title, start, end } = clickedEvent;
                    this.indexToUpdate = id;
                    this.newEvent = {
                        event_name: title,
                        start_date: start,
                        end_date: end
                    };
                } else {
                    alert('Tıklanan etkinlik bulunamadı.');
                }
            } else {
                alert('Geçerli bir etkinlik seçilmedi');
            }
        },
        updateEvent() {
            axios
                .put("/api/calendar/" + this.indexToUpdate, {
                    ...this.newEvent
                })
                .then(resp => {
                    this.resetForm();
                    this.getEvents();
                    this.addingMode = !this.addingMode;
                })
                .catch(err =>
                    console.log("Günceleme İşlemi Başarısız!", err.response.data)
                );
        },
        deleteEvent() {
            axios
                .delete("/api/calendar/" + this.indexToUpdate)
                .then(resp => {
                    this.resetForm();
                    this.getEvents();
                    this.addingMode = !this.addingMode;
                })
                .catch(err =>
                    console.log("Silme İşlemi Başarısız!", err.response.data)
                );
        },
        getEvents: function () {
            axios
                .get("/api/calendar")
                .then(resp => {

                    this.calendarOptions.events = resp.data.data.map(event => {
                        return {
                            id : event.id,
                            title: event.title,
                            start: event.start,
                            end: event.end
                        };
                    });
                })
                .catch(err => console.log(err.response.data));
        },
        resetForm() {
            Object.keys(this.newEvent).forEach(key => {
                return (this.newEvent[key] = "");
            });
        },
        toggleAddingMode() {
            this.addingMode = !this.addingMode;
            this.resetForm();
        },

    },
    watch: {
        indexToUpdate() {
            return this.indexToUpdate;
        }
    }
};
</script>

<style lang="css">
@import "bootstrap";
.fc-title {
    color: #fff;
}

.fc-title:hover {
    cursor: pointer;
}
</style>

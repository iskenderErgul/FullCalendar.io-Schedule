<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <form @submit.prevent>
                    <div class="form-group mb-1">
                        <label for="event_name">Event Name</label>
                        <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name">
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
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
                                <label for="end_date">End Date</label>
                                <input type="date" id="end_date" class="form-control" v-model="newEvent.end_date">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4" v-if="addingMode">
                            <button class="btn btn-sm btn-primary" @click="addNewEvent">Save Event</button>
                        </div>
                        <template v-else>
                            <div class="col-md-6 mb-4">
                                <button class="btn btn-sm btn-success" @click="updateEvent">Update</button>
                                <button class="btn btn-sm btn-danger" @click="deleteEvent">Delete</button>
                                <button class="btn btn-sm btn-secondary" @click="addingMode = !addingMode">Cancel</button>
                            </div>
                        </template>
                    </div>
                </form>
            </div>
            <div class="col-md-8 w-75 h-75 ">

                <FullCalendar @eventClick="showEvent"  :options="calendarOptions" />
            </div>
        </div>
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import axios from "axios";

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
                eventClick: this.showEvent
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
        addNewEvent() {
            axios
                .post("/api/calendar", {
                    ...this.newEvent
                })
                .then(data => {
                    this.getEvents(); // update our list of events
                    this.resetForm(); // clear newEvent properties (e.g. title, start_date and end_date)
                })
                .catch(err =>
                    console.log("Unable to add new event!", err.response.data)
                );
        },
        showEvent(arg) {

            this.addingMode = false;

            
            if (arg.event && arg.event.id) {
                const clickedEvent = this.calendarOptions.events.find(
                    event => event.id === +arg.event.id
                );

                if (clickedEvent) {
                    const { id, title, start, end } = clickedEvent;
                    this.indexToUpdate = id;
                    this.newEvent = {
                        event_name: title,
                        start_date: start,
                        end_date: end
                    };
                } else {
                    console.error("Tıklanan etkinlik bulunamadı.");
                }
            } else {
                console.error("Geçerli bir etkinlik seçilmedi.");
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
                    console.log("Unable to update event!", err.response.data)
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
                    console.log("Unable to delete event!", err.response.data)
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
        }
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

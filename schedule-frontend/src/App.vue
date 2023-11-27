<template>
  <div id="app" class="container mx-auto p-4">
    <table class="table-auto w-full border-collapse">
      <thead>
      <tr>
        <th class="px-4 py-2"></th>
        <th v-for="day in days" :key="day" class="px-4 py-2 border">{{ day }}</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="time in times" :key="time">
        <td class="px-4 py-2 border">{{ time }}</td>
        <td v-for="day in days" :key="day" class="px-4 py-2 border"></td>
      </tr>
      </tbody>
    </table>
  </div>
  <button
      @click="updateTask(65)"
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
    Button
  </button>
</template>

<script>
import axios from "axios";

axios.defaults.baseURL = "http://127.0.0.1:8000/api/";

export default {
  data() {
    return {
      days: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'],
      times: ['08:00 - 09:00', '09:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00', '12:00 - 13:00', '13:00 - 14:00', '14:00 - 15:00', '15:00 - 16:00'],
      tasks: [],
      task: [],
      errors: [],
      form : {
          day_number : '2',
          week_id : '1',
          title : "Ornek Görev 5sasas",
          description : "Ornek görev 5sasas açıklaması",
          start_time : "15:00",
          end_time : "16:00"

        }

    }
  },
  mounted() {
    this.getTasks();
  },
  methods: {
    async getTasks() {
      try {
        const response = await axios.get("tasks");
        this.tasks = response.data;
      } catch (error) {
        console.error("API isteği başarısız: ", error);
      }
    },
    async getTask(id) {
      try {
        const response = await axios.get('tasks/getTask/' + id);
        console.log(response);
        this.task = response.data;
      } catch (error) {
        console.error("API isteği başarısız: ", error);
      }
    },
    async destroyTask(id) {
    try {
      const response = await  axios.delete('tasks/deleteTask/'+id);
      console.log('silindi');
      console.log(response);

    }catch (error) {
      console.error("API isteği başarısız: ", error);
    }


    },
    async addTask() {
      try {
        const response = await axios.post('tasks/addTask',this.form);
        console.log(response);
      }catch (error) {
        console.error("API isteği başarısız: ", error);
      }

    },
    async updateTask(id){
      try {
        const response = await axios.put('tasks/updateTask/'+id,this.form);
        console.log(response);
      }catch (error) {
        console.error("API isteği başarısız: ", error);
      }
    }



  },
}

</script>

<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>
          Add students
        </h4>
      </div>
      <div class="card-body">

        <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
          <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
            {{ error[0] }}
          </li>
        </ul>
        <div class="mb-3">
          <label for="">Name</label>
          <input type="text" v-model="model.student.name" class="form-control">
        </div>
        <div class="mb-3">
          <label for="">Class</label>
          <input type="text" v-model="model.student.class" class="form-control">
        </div>
        <div class="mb-3">
          <label for="">Subject</label>
          <input type="text" v-model="model.student.subject" class="form-control">
        </div>
        <div class="mb-3">
          <button type="button" @click="saveStudent" class="btn btn-primary">Save</button>
          <router-link to="/students" class="btn btn-danger float-end">Back</router-link>

        </div>
      </div>

    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'studentCreate',
  data() {
    return {
      errorList: '',
      model: {
        student: {
          name: '',
          class: '',
          subject: ''
        }
      }
    }
  },
  methods: {

    saveStudent() {

      var mythis = this;
      axios.post('http://127.0.0.1:8000/api/students', this.model.student)
        .then(res => {

          console.log(res.data)
          alert(res.data.message);

          this.model.student = {
            name: '',
            class: '',
            subject: ''
          }
        })
        .catch(function (error) {

          if (error.response) {
            if (error.response.status == 422) {

              mythis.errorList = error.response.data.errors;
            }
          } else {
            console.log('Error', error.message);
          }
        });
    }
  },
}



</script>

<style>
.edit-delete-button {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

.edit-delete-button .btn-success,
.edit-delete-button .btn-danger {
  flex: 1; 
}

@media (max-width: 768px) {
  .edit-delete-button {
    flex-direction: column;
  }
}
</style>
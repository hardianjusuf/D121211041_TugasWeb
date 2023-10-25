<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>
          Update Student Data
        </h4>
      </div>
      <div class="card-body">

        <ul class="alert alert-warning" v-if="errorList.length > 0">
          <li class="mb-0 ms-3" v-for="(error, index) in errorList" :key="index">
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
          <button type="button" @click="updateStudent" class="btn btn-primary">Update</button>
          <router-link to="/students" class="btn btn-danger float-end">Back</router-link>        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'studentEdit',
  data() {
    return {
      studentId: '',
      errorList: [],
      model: {
        student: {
          name: '',
          class: '',
          subject: ''
        }
      }
    }
  },
  mounted() {
    this.studentId = this.$route.params.id;
    this.getStudentData(this.$route.params.id);
  },
  methods: {
    getStudentData(studentId) {
      axios.get(`http://127.0.0.1:8000/api/students/${studentId}/edit`)
        .then(res => {
          this.model.student.name = res.data.student.name;
          this.model.student.class = res.data.student.class;
          this.model.student.subject = res.data.student.subject;
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status == 404) {
              alert(error.response.data.message);
            }
          }
        });
    },
    updateStudent(studentId) {
      var mythis = this;
      axios.put(`http://127.0.0.1:8000/api/students/${this.studentId}/edit`, this.model.student)
        .then(res => {
          alert(res.data.message);
          this.errorList = [];
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status == 422) {
              mythis.errorList = error.response.data.errors;
            }
            if (error.response.status == 404) {
              alert(error.response.data.message);
            }
          } else {
            console.log('Error', error.message);
          }
        });
    }
  },
};
</script>

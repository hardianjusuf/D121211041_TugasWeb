<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h4>
          Students
          <RouterLink to="/students/create" class="btn btn-primary float-end">
            Add Student
          </RouterLink>
        </h4>
      </div>
      <div class="card-body">

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Class</th>
              <th>Subject</th>
              <th>Created at</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody v-if="this.students.length > 0">
            <tr v-for="(student, index) in this.students" :key="index">
              <td>{{ student.id }}</td>
              <td>{{ student.name }}</td>
              <td>{{ student.class }}</td>
              <td>{{ student.subject }}</td>
              <td>{{ student.created_at }}</td>
              <td class='edit-delete-button'>
                <RouterLink :to="{ path: '/students/' + student.id + '/edit' }" class="btn btn-success">
                  Edit
                </RouterLink>
                <button type="button" @click="deleteStudent(student.id)" class="btn btn-danger">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="6">Loading ...</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'students',
  data() {
    return {
      students: []
    }
  },
  mounted() {
    this.getStudents()
  },
  methods: {
    getStudents() {
      axios.get('http://127.0.0.1:8000/api/students').then(res => {
        this.students = res.data.students
      });
    },
    deleteStudent(studentId) {
      if (confirm('Are you sure you want to delete this student Data?')) {
        // Lakukan penghapusan sebenarnya dengan mengirim permintaan DELETE ke API
        axios.delete(`http://127.0.0.1:8000/api/students/${studentId}/delete`)
          .then(res => {
            alert(res.data.message);
            // Perbarui daftar siswa setelah penghapusan berhasil
            this.getStudents();
          })
          .catch(error => {
            console.error(error);
          });
      }
    },
  },
}
</script>

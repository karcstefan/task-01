<template>
  <div>
    <div class="panel panel-default">
      <div class="panel-heading">Rotations list
        <a
          href="#"
            class="btn btn-xs btn-success pull-right"
            v-on:click="addRotation()">
          Add Rotation
        </a>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-4" v-for="rotation, index in rotations">
            <div style="margin-bottom: 10px;">
              Period: {{ rotation.period_start }} - {{ rotation.period_end }}
              <a
                  href="#"
                  class="btn btn-xs btn-danger pull-right"
                  v-on:click="deleteRotation(rotation.id, index)">
                X
              </a>
            </div>
              <div class="list-group">
                <a v-for="pivot, index in rotation.pivot" class="list-group-item" href="#">
                {{ pivot.date }}:&nbsp;
                {{ pivot.employee.first_name }}
                &nbsp;
                {{ pivot.employee.last_name }}
                &nbsp;-&nbsp;
                {{ pivot.shift ? 'Second shift' : 'First shift' }}
                </a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      rotations: []
    }
  },
  mounted() {
    var app = this;
    axios.get('/api/v1/rotations')
        .then(function (resp) {
          app.rotations = resp.data;
        })
        .catch(function (resp) {
          console.log(resp);
        });
  },
  methods: {
    addRotation() {
      var app = this;
      axios.post('/api/v1/rotations')
          .then(function (resp) {
            app.rotations.unshift(resp.data);
          })
          .catch(function (resp) {
            console.log(resp);
          });
    },
    deleteRotation(id, index) {
      var app = this;
      axios.delete('/api/v1/rotations/' + id)
          .then(function (resp) {
            app.rotations.splice(index, 1);
          })
          .catch(function (resp) {
            console.log(resp);
          });
    }
  }
}
</script>

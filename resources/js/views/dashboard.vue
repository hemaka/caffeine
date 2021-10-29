<template>
  <div>
    <h5>{{$route.meta.title}}</h5>
    <div class="card mt-2" v-if="currentDrinks != null">
      <div class="card-body">
        <h5 class="card-title">
          {{currentDrinks.name}}
          <button class="btn btn-sm btn-danger float-end" @click="back()">Back</button>
        </h5>
        <p>{{currentDrinks.description}}</p>
        <div class="row" v-if="currentDrinks.unit.type == 'serving' && currentDrinks.unit.pack == 'can'">
          <div class="col-6">
            {{currentDrinks.caffeine}} mg / per serving
          </div>
          <div class="col-6">
            {{currentDrinks.unit.val}} serving / per can
          </div>
        </div>

        <div class="row" v-if="currentDrinks.unit.type == 'serving' && currentDrinks.unit.pack == 'none'">
          <div class="col-6">
            {{currentDrinks.caffeine}} mg / per serving
          </div>
        </div>

        <div class="row" v-if="currentDrinks.unit.type == 'serving' && currentDrinks.unit.pack == 'fl'">
          <div class="col-6">
            {{currentDrinks.caffeine}} mg / {{currentDrinks.unit.val}} Oz
          </div>
        </div>

        <div class="row" v-if="currentDrinks.unit.type == 'fl'">
          <div class="col-6">
            {{currentDrinks.caffeine}} mg / {{currentDrinks.unit.val}} Oz
          </div>
        </div>

        <div class="form-group">
          <label for="consumed">Drinks consumed</label>
          <div class="input-group mb-3">
            <input
              id="consumed"
              v-model="consumed"
              type="number"
              class="form-control"
              placeholder="Enter drinks consumed"
            />
            <span class="input-group-text">Serving</span>
          </div>
        </div>

        <div class="row">
          <div class="col">
            You consumed <span class="text-warning">{{caffeine}}</span> mg caffeine
          </div>
        </div>

        <div class="row">
          <div class="col" v-if="caffeine <= safeCaffeine">
            You can drink <span class="text-success">{{serving}}</span> serving {{currentDrinks.name}}.
          </div>
          <div class="col" v-else>
            <span class="text-danger">You are not safe!</span>
          </div>
        </div>

      </div>
    </div>
    <div v-else>
      <div class="card mt-2" :key="item.id" v-for="item in drinks">
        <div class="card-body">
            <h5 class="card-title">
              {{item.name}}
              <button class="btn btn-sm btn-info float-end" @click="sel(item)">Select</button>
            </h5>
            
            <div class="row" v-if="item.unit.type == 'serving' && item.unit.pack == 'can'">
              <div class="col-6">
                {{item.caffeine}} mg / per serving
              </div>
              <div class="col-6">
                {{item.unit.val}} serving / per can
              </div>
            </div>

            <div class="row" v-if="item.unit.type == 'serving' && item.unit.pack == 'none'">
              <div class="col-6">
                {{item.caffeine}} mg / per serving
              </div>
            </div>

            <div class="row" v-if="item.unit.type == 'serving' && item.unit.pack == 'fl'">
              <div class="col-6">
                {{item.caffeine}} mg / {{item.unit.val}} Oz
              </div>
            </div>

            <div class="row" v-if="item.unit.type == 'fl'">
              <div class="col-6">
                {{item.caffeine}} mg / {{item.unit.val}} Oz
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

</template>
<script>
import { required } from "vuelidate/lib/validators";
export default {
  computed:{
    caffeine(){
      return this.currentDrinks.caffeine * this.consumed;
    },
    serving(){
      return parseInt((this.safeCaffeine - this.currentDrinks.caffeine * this.consumed) / this.currentDrinks.caffeine)
    }
  },
  data() {
    return {
      user: window.user,
      drinks: [],
      isLoading: false,
      currentDrinks: null,
      consumed: 0,
      safeCaffeine: 500,
    };
  },
  validations: {
    locationdata: {
      name: { required },
      description: {},
      caffeine: {required},
    },
  },
  mounted() {
    console.log("Dashboard mounted. ");
    this.fetchData();
  },
  methods: {
    fetchData(){
      this.$http
        .get("/drinks")
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          this.drinks = data.data;
        });
    },
    back(){
      this.currentDrinks = null;
      this.consumed = 0;
    },
    sel(item){
      this.currentDrinks = item;
      this.consumed = 0;
    }
  }
};
</script>

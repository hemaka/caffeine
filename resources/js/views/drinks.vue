<template>
  <div>
    <h5>{{$route.meta.title}}</h5>
    <div v-if=" user.name != 'demo'">
      <div class="row" v-if="!showEditor">
        <div class="col">
          <button class="btn btn-primary btn-sm" @click="showEditor = true">Add new Drink</button>
        </div>
      </div>
      <div class="card" v-else>
        <div class="card-body">
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label for="name">Drinks name</label>
              <input
                id="name"
                v-model="newDrinks.name"
                type="text"
                class="form-control"
                placeholder="Enter drinks name"
                :class="{ 'is-invalid': $v.newDrinks.name.$error }"
              />
              <div
                v-if="!$v.newDrinks.name.required"
                class="invalid-feedback"
              >
                Drinks name is require.
              </div>
            </div>

            <div class="form-group">
              <label for="description">Drinks description</label>
              <textarea
                id="description"
                v-model="newDrinks.description"
                class="form-control"
                placeholder="Enter drinks description"
                style=""
              ></textarea>
            </div>

            <div class="form-group">
              <label for="caffeine">Drinks caffeine</label>
              <div class="input-group mb-3">
                <input
                  id="caffeine"
                  v-model="newDrinks.caffeine"
                  type="number"
                  class="form-control"
                  placeholder="Enter drinks caffeine"
                  :class="{ 'is-invalid': $v.newDrinks.caffeine.$error }"
                />
                <span class="input-group-text">mg</span>
              </div>
              <div
                v-if="$v.newDrinks.caffeine.$error "
                class="invalid-feedback"
              >
                Drinks caffeine must > 1.
              </div>
            </div>

            <div class="form-group">
              <label for="caffeine">Drinks unit</label>
              <div class="input-group mb-3">
                <select class="form-select" id="unitType" v-model="newDrinks.unit.type">
                  <option :value="item" :key="index" v-for="(item, index) in unit.type">{{item}}</option>
                </select>

                <input type="number"  v-if="newDrinks.unit.type == 'fl'" v-model="newDrinks.unit.val" class="form-control" placeholder="input unit value" :class="{ 'is-invalid': $v.newDrinks.unit.$error }">
                <span class="input-group-text" v-if="newDrinks.unit.type == 'fl'">Oz</span>


                <select class="form-select" id="unitPack" v-model="newDrinks.unit.pack"  v-if="newDrinks.unit.type == 'serving'">
                  <option :value="item" :key="index" v-for="(item, index) in unit.pack">{{item}}</option>
                </select>
                <input type="number"  v-if="newDrinks.unit.type == 'serving' && newDrinks.unit.pack!='none'" v-model="newDrinks.unit.val" class="form-control" placeholder="input unit pack value" :class="{ 'is-invalid': $v.newDrinks.unit.$error }">
                <span class="input-group-text" v-if="newDrinks.unit.type == 'serving' && newDrinks.unit.pack == 'can'">Serving</span>
                <span class="input-group-text" v-if="newDrinks.unit.type == 'serving' && newDrinks.unit.pack == 'fl'">Oz</span>
              </div>

              <div
                v-if="!$v.newDrinks.unit.unitTest"
                class="invalid-feedback"
              >
                Unit value must > 1.
              </div>
            </div>

            <div class="form-group mt-2">
              <button class="btn btn-secondary btn-sm" @click="showEditor = false" :disabled="this.submitted">Cancel</button> <button type="submit" :disabled="this.submitted" class="btn btn-danger btn-sm">Save</button>
            </div>

          </form>
        </div>
      </div>
    </div>

    <div class="card mt-2" :key="item.id" v-for="item in drinks">
      <div class="card-body">
          <h5 class="card-title">
            {{item.name}}
            <button class="btn btn-sm btn-danger float-end" v-if="item.user_id == user.id" @click="del(item)">Delete</button>
          </h5>
          <p>{{item.description}}</p>
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

</template>
<script>
import { required, minValue, maxValue, requiredIf } from "vuelidate/lib/validators";
export default {
  data() {
    return {
      user: window.user,
      drinks: [],
      unit: {
        type: ['serving', 'fl'],
        pack: ['can','none', 'fl'],
      },
      newDrinks:null,
      isLoading: false,
      showEditor: false,
      submitted: false,
    };
  },
  validations: {
    newDrinks: {
      name: { required },
      description: {},
      caffeine: {minValue: minValue(1), maxValue: maxValue(500)},
      unit: {unitTest: function(){
        console.log('unitTest');
        if(this.newDrinks.unit.type == 'serving'){
          if(this.newDrinks.unit.pack != 'none' && (this.newDrinks.unit.val == 0 || this.newDrinks.unit.val > 20)){
            return false;
          }
        }else if(this.newDrinks.unit.type == 'fl'){
          if(this.newDrinks.unit.val == 0 || this.newDrinks.unit.val == 20 ){
            return false;
          }
        }else{
          return false;
        }
        return true;
      }}
    },
  },
  mounted() {
    console.log("Drinks mounted. ");
    this.initNewDrinks();
    this.fetchData();
  },
  methods: {
    // get all drinks
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
    // init new drinks data
    initNewDrinks(){
      this.newDrinks = {
        name: '',
        description: '',
        caffeine: 0,
        unit: {
          type: this.unit.type[0],
          pack: this.unit.pack[0],
          val: 0, 
        },
      }
    },
    // submit new drinks data
    handleSubmit(e) {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      } else {
        this.submitted = true;
        this.$http
          .post("/drinks", this.newDrinks)
          .then((response) => {
            return response.json();
          }, response => {
            return false;
          })
          .then((data) => {
            this.showEditor = false;
            this.drinks.push(data.data);
            this.initNewDrinks();
            this.submitted = false;
          });
      }
    },

    del(item){
      this.drinks.splice(this.drinks.indexOf(item), 1);
      this.$http
        .delete("/drinks/"+item.id)
        .then((response) => {
          return response.json();
        })
        .then((data) => {
        });
    }
  }
};
</script>

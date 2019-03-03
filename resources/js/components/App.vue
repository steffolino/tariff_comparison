<template>
    <div id="app">
        <div class="input-wrapper">
            <div class="inner-input-wrapper">
                <!-- TODO: replace with slider for selection -->
                <label for="kwhperyear">Your kwH Per Year</label>
                <input id="kwhperyear" type="number" name="kwhperyear" placeholder="kWh per year" step="50" v-model="consumption"/>
            </div>
        </div>
        <!-- Template TariffsComponent.vue -->
        <transition-group name="tariff-wrapper" class="tariff-wrapper">
            <tariff-component
                    v-for="(tariff, index) in tariffs"
                    v-bind="tariff"
                    :key="tariff.id"
                    :index="index"
                    @update="update"
                    @delete="del"
                    :consumption="consumption"
            ></tariff-component>
        </transition-group>
    </div>
</template>

<script>
    function Tariff({ id, name, annual_costs, monthly, per_kwh, flatrate_consumption, flatrate_price, index}) {
        this.index = index;
        this.id = id;
        this.name = name;
        this.annual_costs = annual_costs;
        this.monthly = monthly;
        this.per_kwh = per_kwh;
        this.flatrate_consumption = flatrate_consumption;
        this.flatrate_price = flatrate_price;
        this.totalCosts = this.monthly * 12 - this.monthly;
    }

    import TariffComponent from './TariffsComponent.vue';

    export default {
        data() {
            return {
                tariffs: [],
                consumption: 0
            }
        },
        /** TODO: enable create, update, delete ***/
        methods: {
            create() {
                window.axios.get('/api/tariffs/create').then(({ data }) => {
                    this.tariffs.push(new Tariff(data));
                });
            },
            read() {
                window.axios.get('/api/tariffs').then(({ data }) => {
                    data.forEach(tariff => {
                        this.tariffs.push(new Tariff(tariff));
                    });
                });
            },
            update(id, color) {
                window.axios.put(`/api/tariffs/${id}`, { color }).then(() => {
                    this.tariffs.find(tariff => tariff.id === id).color = color;
                });
            },
            del(id) {
                window.axios.delete(`/api/tariffs/${id}`).then(() => {
                    let index = this.tariffs.findIndex(tariff => tariff.id === id);
                    this.tariffs.splice(index, 1);
                });
            },
            /** calculate annual_costs depending on consumption input **/
            calcTotalCosts(tariff) {
                if(this.consumption == 0) {
                    tariff.annual_costs = 0;
                }
                else if (tariff.flatrate_consumption != null && this.consumption < tariff.flatrate_consumption) {
                    tariff.annual_costs = parseFloat(tariff.flatrate_price).toFixed(2);
                } else if(tariff.flatrate_consumption != null) {
                    tariff.annual_costs = parseFloat(tariff.flatrate_price + ((this.consumption - tariff.flatrate_consumption) * tariff.per_kwh)).toFixed(2);
                } else {
                    tariff.annual_costs = parseFloat(12*tariff.monthly + parseFloat(this.consumption * tariff.per_kwh)).toFixed(2);
                }
            },
            sortTariffs: function () {
                return this.tariffs = this.tariffs.sort((a, b) => {return a.annual_costs - b.annual_costs});
                //return _.orderBy(this.tariffs, parseFloat('annual_costs'));
            }

        },
        watch: {
            'consumption': function(newVal, oldVal) {
                for (let i = 0; i < this.tariffs.length; i++) {
                    this.calcTotalCosts(this.tariffs[i]);
                }
                this.tariffs = this.sortTariffs();
            }
        },
        components: {
            TariffComponent
        },
        created() {
            this.read();
        }
    }
</script>
<!-- TODO: move to scss -->
<style>
    #app {
        font-family: Lato, sans-serif;
    }

    .input-wrapper {
        width: 100%;
        height: 100px;
        position: fixed;
        background: #FFFBFC;
        /*TODO: test why chrome fails with top property*/
        top: -1px;
        margin-left: auto;
        margin-right: auto;
        justify-content: center;
        display:flex;
        -webkit-box-shadow: 0 3px 18px -6px #666;
        -moz-box-shadow: 0 3px 18px -6px #666;
        box-shadow: 0 3px 18px -6px #666;
        z-index: 1;
    }
    .input-wrapper .inner-input-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center

    }

    .input-wrapper .inner-input-wrapper input {
        height: 50%;
        align-self: center;
        padding-left: 1em;
        font-size: 1.1em;
    }

    .heading h1 {
        margin-bottom: 0;
    }

    .tariff-wrapper {
        display: inline-flex;
        width: calc(100% - 30px);
        flex-wrap: wrap;
        transition-duration: .6s;
        margin-top: 100px;
        padding: 5px 15px;
        justify-content: center;
    }
    .tariff-wrapper-move {
        transition: transform .6s;
    }
    .tariff-wrapper-enter, .tariff-wrapper-leave-to /* .list-leave-active below version 2.1.8 */ {
        opacity: 0;
        transform: translateY(30px);
    }

</style>
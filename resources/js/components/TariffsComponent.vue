<template>
        <div class="tariff">
            <div class="row-1">
                <h3>Tariff Name: {{ name | properCase }}</h3>
                <div class="indexIndicator">{{ corrIndex }}</div>
            </div>
            <div class="row-2">
                <ul>
                    <li>Costs per month: {{ monthly }}</li>
                    <li>Costs per kwh: {{ per_kwh }}</li>
                    <li>Flatrate Cons.: {{ flatrate_consumption | replaceNull }}</li>
                    <li>Flatrate Price: {{ flatrate_price | replaceNull }}</li>
                </ul>
            </div>
            <div class="row-3">
                <p><strong>Total Annual Costs: {{ annual_costs }}€</strong></p>
            </div>
        </div>
</template>
<script>
    export default {
        computed: {
            corrIndex () {
                return this.index + 1;
            }
        },
        methods: {
            update(val) {
                this.$emit('update', this.id, val.target.selectedOptions[0].value);
            },
            del() {
                this.$emit('delete', this.id);
            }
        },
        props: ['id', 'name', 'annual_costs', 'monthly', 'per_kwh', 'flatrate_consumption', 'flatrate_price', 'consumption', 'index'],
        filters: {
            properCase(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
            replaceNull(prop) {
                if(prop == null) {
                  return 'Not available';
                }
                return prop;
            }
        }
    }
</script>
<!-- TODO: move to scss -->
<style>
    .tariff {
        margin: 1em 1em 1em 1em;
        border: 1px solid #546A7B;
        padding: 1em;
        width: 300px;
        min-height:200px;
        background-color: #fffbfc;
        position: relative;
    }

    .indexIndicator {
        position: absolute;
        top: 5px;
        right: 10px;
        border-radius: 50%;
        background: #1481BA;
        width: 25px;
        height: 25px;
        line-height: 25px;
        color: white;
        font-weight: 700;
    }

    .row-1 {
        text-align:center;
    }
    .row-1 > h3 {
        color: #001021;
    }

    .row-2 {
        margin-left: 2.3em;
    }

    .row-3 {
        text-align: center;
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        border-top: 1px solid #ccc;
    }
</style>
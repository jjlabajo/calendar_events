<template>
    <button v-if="month > 1" @click="update(month - 1, year)">Previous</button>
    <button v-if="month < 12" @click="update(month + 1, year)">Next</button>
    <h2>{{month_text}} {{ year }}</h2>
    <table>
        <tr v-for="(value, x) in monthDays" :key="x"> 
            <td v-if="value.event.trim() === ''" :style="{ backgroundColor: '#FFFFF' }">{{ x + 1 }} {{ value.day }}</td>
            <td v-else :style="{ backgroundColor: '#DFFFEC' }">{{ x + 1 }} {{ value.day }}</td>
            <td v-if="value.event.trim() === ''" :style="{ backgroundColor: '#FFFFF' }">{{ value.event }}</td>
            <td v-else :style="{ backgroundColor: '#DFFFEC' }">{{ value.event }}</td>
        </tr>
    </table>
</template>

<script>
export default {
    name: "AddEvent",
    props: {
        refresh: Boolean
    },
    data() {
        return {
            month: 0,
            year: 2019,
            month_text : "",
            days: [
                "Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"
            ],
            monthDays: []
        }
    },
    watch: {
        refresh: function(newVal, oldVal){
            if(newVal){
                this.getEvents()
            }
        }
    },
    methods: {
        formatEvents(json){
            var events = [];
            for(var x of json){
                events[`${x.month} ${x.day} ${x.year}`] = x.event_name
            }
            return events
        },
        daysInMonth(json) {
            var events = this.formatEvents(json)
            var days = [];
            var day = 0;
            for(var x of new Array(new Date(this.year, this.month, 0).getDate())){
                day = day + 1;
                var event_name = ""
                var index = `${this.month} ${day} ${this.year}`;
                if(index in events){
                    event_name = events[index]
                }
                var color = "#FFFFFF"
                if(event_name.trim() !== ""){
                    color = "#DFFFEC"
                }
                days.push({
                    day: this.getDay(day),
                    event : event_name,
                    background : {
                        backgroundColor : color
                    }
                })
            }
            this.monthDays = days;
        },
        update(month, year){
            var months = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                        ]
            this.month = month
            this.month_text = months[month - 1]
            this.year = year
            this.getEvents()
        },
        getDay(day){
            return this.days[new Date(`${this.month_text} ${day}, ${this.year}`).getDay()]
        },
        getEvents(){
            fetch(`api/events/${this.month}/${this.year}`)
            .then((response) => response.json())
            .then((json) => {this.daysInMonth(json); this.$emit('doneRefresh');});
        }
    },
    created(){
        this.update((new Date().getMonth() + 1), new Date().getFullYear())
    }
}
</script>

<style scoped>
    table{
        width: 100%;
    }
    td{
        padding: 10px;
        margin-right:50px;
        border-top: 1px solid rgb(202, 202, 202);
    }
</style>
<template>
    <div class="container">
        <h1>Calendar</h1>
        <hr>
        <div>
            <div class="box add-event">
                <AddEvent @add-event="refreshCalendar"></AddEvent>
            </div>
            <div class="box calendar">
                <Calendar :refresh="refresh" @done-refresh="refresh = false"></Calendar>
            </div>
        </div>
    </div>
</template>

<script>
import AddEvent from './AddEvent.vue'
import Calendar from './Calendar.vue'

export default {
    name: 'App',
    data(){
        return {
            refresh : false
        }
    },
    components: {
        AddEvent,
        Calendar
    },
    methods: {
        refreshCalendar(){
            console.log("refreshing..")
            this.refresh = true
        }
    }
}
</script>
<style scoped>
    .container{
        margin: 5px;
        padding: 10px;
        width: 100%;
    }
    .box{
        float: left;
        margin:3px;
    }
    .add-event{
        width: 30%;
    }
    .calendar{
        width: 65%;
    }
</style>
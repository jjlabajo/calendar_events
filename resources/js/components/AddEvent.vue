<template>
    <div>
        <p>Event</p>
        <input type="text" v-model="event_name" placeholder="My Event">
        <div>
            <div class="fifty">
                <p>From</p>
                <input type="date" v-model="from">
            </div>
            <div class="fifty">
                <p>To</p>
                <input type="date" v-model="to">
            </div>
        </div>
        <div>
            <input type="checkbox" value="Monday" v-model="days"> Monday
            <input type="checkbox" value="Tuesday" v-model="days"> Tuesday
            <input type="checkbox" value="Wednesday" v-model="days"> Wednesday
            <input type="checkbox" value="Thursday" v-model="days"> Thursday
            <input type="checkbox" value="Friday" v-model="days"> Friday
            <input type="checkbox" value="Saturday" v-model="days"> Saturday
            <input type="checkbox" value="Sunday" v-model="days"> Sunday
        </div>
        <hr>
        <div>
            <button @click="save()">Save</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "AddEvent",
    data(){
        return {
            event_name : "",
            from : "",
            to : "",
            days : []
        }
    },
    methods: {
        save(){
            if(this.event_name.trim() == ""){
                alert("Event name field is required.");
                return 
            }
            if(this.from.trim() == ""){
                alert("From field is required.");
                return 
            }
            if(this.to.trim() == ""){
                alert("To field is required.");
                return 
            }
            if(this.days.length == 0){
                alert("Days field is required.");
                return 
            }
            var days = [
                "Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"
            ]
            var events = [];
            for(var x of this.dateRange(this.from, this.to)){
                if(this.days.includes(days[x.getDay()])){
                    events.push({
                        event_name : this.event_name,
                        month : x.getMonth() + 1,
                        year : x.getFullYear(), 
                        day: x.getDate()
                    })
                }
            }
            if(events.length == 0){
                alert("No events can be added on those days.");
                return 
            }
            fetch(`api/events`, {
                method: 'POST',
                body: JSON.stringify({
                    events: events
                }),
                headers: {
                    'Content-type': 'application/json; charset=UTF-8',
                },
                })
                .then((response) => response.json())
                .then((json) => {console.log(json); this.$emit('addEvent');});
        },
        dateRange(startDate, endDate, steps = 1) {
            const dateArray = [];
            let currentDate = new Date(startDate);

            while (currentDate <= new Date(endDate)) {
                dateArray.push(new Date(currentDate));
                // Use UTC date to prevent problems with time zones and DST
                currentDate.setUTCDate(currentDate.getUTCDate() + steps);
            }

            return dateArray;
        }
    }
}
</script>

<style scoped>
    .fifty{
        width:50%;
        float:left;
    }
</style>
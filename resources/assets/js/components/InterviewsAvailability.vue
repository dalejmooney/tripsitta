<template>
    <div class="babysitter-availability">
        <v-calendar is-expanded :columns="2" :rows="3" :attributes='av' @dayclick="dayClick"></v-calendar>
        <input type="hidden" :value="this.datesToJson()" name="fields"/>
    </div>
</template>

<script>
    import Calendar from 'v-calendar/lib/components/calendar.umd'

    export default {
        name: "InterviewsAvailability",
        props: {
            availability: { type: String },
        },
        created() {
            let availability_array = JSON.parse(this.availability);

            var list = [];
            availability_array.map(function(value, key) {
                list.push({
                    dates: new Date(value),
                    bar: 'orange',
                });
            });

            this.av = list;
        },
        data() {
            return {
                av: [],
            };
        },
        components: {
            'v-calendar': Calendar
        },
        methods: {
            dayClick(event) {
                if(event.attributes && event.attributes.length > 0)
                {
                    const func = (el) => {
                        let el_date = el.dates;
                        el_date.setMinutes(el_date.getMinutes() - el_date.getTimezoneOffset());
                        el_date = el_date.toJSON().slice(0, 10);

                        let event_date = event.date;
                        event_date.setMinutes(event_date.getMinutes() - event_date.getTimezoneOffset());
                        event_date = event_date.toJSON().slice(0, 10);

                        return el_date === event_date;
                    }
                    let i = this.av.findIndex(func);

                    if(i >= 0){
                        this.av.splice(i, 1);
                    }

                    return;
                }

                let { year, month, day } = event;

                this.av.push({
                    dates: new Date(year, month - 1, day),
                    bar: 'orange',
                });
            },

            datesToJson() {
                let lista = [];
                this.av.map(function(value, key) {
                    let local = new Date(value.dates);
                    local.setMinutes(local.getMinutes() - local.getTimezoneOffset());

                    lista.push({
                        dates: local.toJSON().slice(0, 10),
                        bar: 'orange',
                    });
                });

                return JSON.stringify(lista);
            }
        },
    }
</script>

<style>

</style>

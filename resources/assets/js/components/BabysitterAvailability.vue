<template>
    <div class="babysitter-availability">
        <v-calendar is-expanded :columns="2" :rows="2" :attributes='availability_array' @dayclick="dayClick"></v-calendar>
        <div class="legend">
            <template v-if="calendar_type === 'babysitter' || calendar_type === 'bookings'">
                <span class="block-bd"></span> Babysitter - Day
                <span class="block-bn"></span> Babysitter - Night
            </template>
            <template v-if="calendar_type === 'holiday_nanny' || calendar_type === 'bookings'">
                <span class="block-h"></span> Holiday nanny
            </template>
        </div>

        <input type="hidden" :value="this.datesToJson()" :name="'availability_' + calendar_type" v-if="calendar_type !== 'bookings'"/>
    </div>
</template>

<script>
    import Calendar from 'v-calendar/lib/components/calendar.umd'

    export default {
        name: "BabysitterAvailability",
        props: {
            calendar_type: {
                type: String,
            },
            babysitter_availability: {
                type: Object,
            },
            holiday_nanny_availability: {
                type: Array
            },
            bookings: {
                type: Array,
            }
        },
        created() {
            window['TWILL'].STORE.form.fields.push({
                name: 'availability_' + this.calendar_type,
                value: ''
            });

            this.setAvailabilityArray();
        },
        data() {
            return {
                availability_array: [],
                availability: {
                    'bm':
                    {
                        bar: 'orange',
                        popover: {
                            label: 'Available as Babysitter - Morning',
                        },
                        dates: this.babysitter_availability.day,
                    },
                    'be':
                    {
                        bar: 'blue',
                        popover: {
                            label: 'Available as Babysitter - Evening',
                        },
                        dates: this.babysitter_availability.night,
                    },
                    'hn':
                    {
                        bar: 'red',
                        popover: {
                            label: 'Available as Holiday nanny',
                        },
                        dates: this.holiday_nanny_availability,
                    },
                    'b': {
                        ...this.bookings.map(booking => ({
                            dates: booking.dates,
                            bar: booking.color,
                            popover: {
                                label: booking.description,
                            },
                        })),
                    }
                },
            };
        },
        computed: {

        },
        methods: {
            dayClick(event) {
                if(this.calendar_type === 'holiday_nanny')
                {
                    if(!event.attributes || event.attributes.length <= 0){
                        this.availability.hn.dates.push(event.id);

                        this.setAvailabilityArray();

                        return;
                    }

                    event.attributes.map((e_attr_value) => {
                        if (e_attr_value.bar.base.color === 'red') {
                            let event_date = event.date;
                            event_date.setMinutes(event_date.getMinutes() - event_date.getTimezoneOffset());
                            event_date = event_date.toJSON().slice(0, 10);

                            let i = this.availability.hn.dates.indexOf(event_date);

                            if(i >= 0){
                                this.availability.hn.dates.splice(i, 1);
                            }

                            this.setAvailabilityArray();
                        }
                    });
                }
                else if(this.calendar_type === 'babysitter')
                {
                    if(!event.attributes || event.attributes.length <= 0){
                        this.availability.be.dates.push(event.id);
                        this.availability.bm.dates.push(event.id);

                        this.setAvailabilityArray();

                        return;
                    }

                    let event_date = event.date;
                    event_date.setMinutes(event_date.getMinutes() - event_date.getTimezoneOffset());
                    event_date = event_date.toJSON().slice(0, 10);

                    let be_count = this.availability.be.dates.indexOf(event_date);
                    let bm_count = this.availability.bm.dates.indexOf(event_date);

                    if(be_count >= 0 && bm_count >= 0)
                    {
                        this.availability.bm.dates.splice(bm_count, 1);
                    }
                    else if(be_count >= 0 && bm_count === -1){
                        this.availability.be.dates.splice(be_count, 1);
                        this.availability.bm.dates.push(event.id);
                    }
                    else if(bm_count >= 0 && be_count === -1){
                        this.availability.bm.dates.splice(bm_count, 1);
                    }

                    this.setAvailabilityArray();
                }
            },

            setAvailabilityArray()
            {
                if(this.calendar_type === 'holiday_nanny'){
                    this.availability_array = [ this.availability.hn ];
                    this.updateVuex();
                    return;
                }
                else if(this.calendar_type === 'babysitter'){
                    this.availability_array = [ this.availability.bm, this.availability.be ];
                    this.updateVuex();
                    return;
                }

                this.availability_array = Object.values(this.availability.b);
                this.updateVuex();
            },

            updateVuex(){
                let field_id = window['TWILL'].STORE.form.fields.findIndex((e) => e.name === 'availability_' + this.calendar_type);

                window['TWILL'].STORE.form.fields[field_id] = {
                    name: 'availability_' + this.calendar_type,
                    value: this.datesToJson()
                };
            },

            datesToJson() {
                return JSON.stringify(this.availability_array);
            }
        },
        components: {
            'v-calendar': Calendar
        },
    }
</script>

<style>
    .babysitter-availability{
        padding:20px 0 0 0;
    }
    .vc-container{
        border-radius: 0;
    }
    /*.vc-dots{*/
    /*    margin-bottom:24px;*/
    /*}*/
    .vc-bar{
        margin:0 1px;
    }

    .legend{
        padding:15px 0 0 0;
    }

    .legend .block-bd, .legend .block-bn, .legend .block-h
    {
        display:inline-block;
        width:10px;
        height:10px;
        margin-left:10px;
    }
    .legend .block-bd{
        background: orange;
    }
    .legend .block-bn{
         background: blue;
    }
    .legend .block-h{
        background: red;
    }

</style>

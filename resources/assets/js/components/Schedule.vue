<template>
    <div class="container">
        <div class='rasp'>
            <div v-if='isLoading' class='spiner-or-text'>Загружаю данные...</div>
            <div v-else class="raspisanie-header">
                <h2
                >Расписание</h2>
                <p class="raspisanie-week">{{dayAsString[0]}}, {{dayAsString[4]}} </p>
            </div>
            <div class="raspisanie-table">
                <table class="days">
                    <tr>
                        <th class='th'>День недели</th>
                    </tr>
                    <tr
                            v-for="(day, index) in weekDays"
                            v-if="day.length > 0"
                    >
                        <td v-bind:class="{'active': dayAsString[3] === day[3]}"
                            v-on:click.prevent="getSchedule(day[1])"
                        >
                            <a href="">{{day[2]}}</a>
                        </td>
                    </tr>
                </table>

                <table class="lessons">
                    <tr>
                        <th>Номер пары</th>
                        <th>Аудитория</th>
                        <th>Предмет</th>
                        <th v-if="user === 0">Группа</th>
                        <th v-else>Преподаватель</th>
                    </tr>

                    <tr v-for="(lesson, index) in schedule['lessons']">
                        <td>{{ index }}</td>
                        <td>
                            <p v-if='lesson[1]'><b>1 подгруппа</b> {{lesson[1]['room']}}</p>
                            <p v-if='lesson[2]'><b>2 подгруппа</b> {{lesson[2].room}}</p>
                            <p v-else>{{lesson.room}} </p>
                        </td>
                        <td>
                            <p v-if='lesson[1]'><b>1 подгруппа</b> {{lesson[1]['discipline']}}</p>
                            <p v-if='lesson[2]'><b>2 подгруппа</b> {{lesson[2].discipline}}</p>
                            <p v-else>{{lesson.discipline}} </p>
                        </td>
                        <td v-if="user === 0">
                            <p v-if='lesson[1]'><b>1 подгруппа </b>{{lesson[1].group}}</p>
                            <p v-if='lesson[2]'><b>2 подгруппа</b> {{lesson[2].group}}</p>
                            <p v-else>{{lesson.group}}</p>
                        </td>
                        <td v-else>
                            <p v-if='lesson[1]'><b>1 подгруппа </b>{{lesson[1].teacher}}</p>
                            <p v-if='lesson[2]'><b>2 подгруппа</b> {{lesson[2].teacher}}</p>
                            <p v-else>{{lesson.teacher}}</p>
                        </td>
                    </tr>


                </table>
            </div>
        </div>

    </div>
</template>
<style>
    .days {
        float: left;
        width: 20%
    }

    .days tr .th {
        border-right: 1px solid #fff !important;
    }

    .lessons {
        width: 80%;
    }

</style>

<script>
    export default {
        name: 'rasp',

        data: () => ({
            isLoading: false,
            schedule: [],
            weekDays: [],
            user: 2,
            dayAsString: [],
            selectedIndex: 0

        }),
        created() {
            this.init();
        },
        methods: {
            async init() {
                this.isLoading = true;
                var now = new Date();
                const weekDays = await axios.get('/profile/getweek', {data: new Date}
                ).catch((error) => console.log(error.response.data));
                this.getSchedule(now);
                this.weekDays = weekDays.data;
                this.isLoading = false;
            },
            async getSchedule(day) {
                const params = {data: day};
                const response = await axios.get('/profile/schedule', {params}
                ).catch((error) => console.log(error.response.data));
                this.schedule = response.data;
                this.user = response.data.isStudent;
                this.dayAsString = this.weekDays[this.schedule.day];
            }
        },

    }
</script>

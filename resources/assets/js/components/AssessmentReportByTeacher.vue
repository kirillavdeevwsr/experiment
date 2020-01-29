<template>

    <div class="container">

        <div class="row" id="messages">
            <div class="col-md-12">
                <div class="alert alert-danger" v-if="messages.teacher">Вы не выбрали преподавателя</div>
            </div>
            <div class="col-md-12">
                <div class="alert alert-danger" v-if="messages.date">Вы не выбрали отчетный период</div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Выберите отчетный период:</label>
                            <div class="row">
                                <input type="month" class="form-control ml-3 mr-3" v-model="date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Выберите преподавателя:</label>
                            <v-select v-model="selectedTeacher" :options="teachers" label="full_name"></v-select>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="data !== null && data.assessments !== 404">

                    <div class="row mt-3 mb-3" v-if="data.assessments">
                        <div class="col-md-12 col-sm-12">
                            Итого подтвержденных баллов: {{parseFloat(this.data.point_accepted).toFixed(2)}}
                        </div>
                        <div class="col-md-12 col-sm-12">
                            Итого неподтвержденных баллов: {{parseFloat(this.data.point_new).toFixed(2)}}
                        </div>
                        <div class="col-md-12 col-sm-12">
                            Итого отклоненных баллов: {{parseFloat(this.data.point_denied).toFixed(2)}}
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="card mt-3" v-for="item in data.assessments" :class="`border-${item.status_color}`">
                            <div class="card-header">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 col-sm-6 text-center">
                                        {{item.users.full_name}}
                                    </div>
                                    <div class="col-md-6 col-sm-6 text-center">
                                        {{item.forPeriod}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p><b>Критерий: </b> {{item.assessment.criterion}}</p>
                                <p><b>Единица показателя,уровни мероприятия: </b>{{item.assessment.unit_of_measure}}</p>
                                <p><b>Критерии оценки: </b>
                                <p v-for="crit in item.assessment.criterions">{{crit.name}} - <b>{{crit.point}} балла (ов)</b></p></p>
                                <p><b>Источник данных: </b>{{item.assessment.data_source}}</p>
                                <p><b>Периодичность подведения итогов: </b>{{item.assessment.periodicity.name}}</p>
                                <p><b>Периодичность выплат: </b>{{item.assessment.frequency_payment.name}}</p>
                                <p><b>Вложенные файлы: </b><a :href="item.attachment" target="_blank">{{item.attachment}}</a></p>
                                <p><b>Баллов: </b>{{item.point}}</p>
                            </div>
                            <div class="card-footer">
                                <b>Ответственный за проверку критерия:</b> {{item.assessment.responsible.full_name}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center" v-else-if="data == 404">
                    <h3>Нет данных!</h3>
                </div>

                <div class="row justify-content-center" v-if="loadingData">
                    <div class="lds-default">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import "vue-select/dist/vue-select.css";

    export default {
        data: () => ({
            data: null,
            loadingData: false,
            date: '',
            teachers: null,
            selectedTeacher: null,
            messages: {
                date: null,
                teacher: null
            }
        }),
        created() {
            this.initData();
        },
        methods: {
            initData() {
                fetch('report/teacher/init-data').then((response) => {
                    if (response.status == 200) {
                        response.json().then((data) => {
                            this.teachers = data;
                        });
                    }
                })
            },

            getData() {
                this.loadingData = true;
                axios.get('report/teacher', {
                    params: {
                        teacherId: this.selectedTeacher.id,
                        date: this.date
                    }
                }).then((response) => {
                    this.data = response.data;
                    this.loadingData = false;
                }).catch((error) => {
                    this.data = 404;
                    this.loadingData = false;
                });
            },
        },
        watch: {
            date() {
                if(this.selectedTeacher == null)
                    this.messages.teacher = true;
                else
                    this.messages.teacher = false;

                if(this.date != '')
                    this.messages.date = false;
                else
                    this.messages.date = true;

                if (this.date != '' && this.selectedTeacher != null)
                    this.getData();
            },

            selectedTeacher() {
                if(this.date == '')
                    this.messages.date = true;
                else
                    this.messages.date = false;

                if(this.selectedTeacher != null)
                    this.messages.teacher = false;
                else
                    this.messages.teacher = true;

                if (this.selectedTeacher != null && this.date != null)
                    this.getData();
            }
        }
    }
</script>

<style scoped>

</style>
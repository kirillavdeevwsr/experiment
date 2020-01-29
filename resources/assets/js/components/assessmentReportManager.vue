<template>
    <div>
        <div class="row" v-if="errors">
            <div class="col">
                <p v-if="errors.first_date" class="text-danger">{{errors.first_date}}</p>
                <p v-if="errors.criterion" class="text-danger">{{errors.criterion}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Выберите период</label>
                    <div class="form-inline align-items-baseline">
                        c <input type="month" class="form-control mr-3 ml-2" v-model="first_date">
                        по <input type="month" class="form-control ml-2" v-model="last_date">
                        <ul id="selectBox" class="ml-3">
                            <li class="init">Выберите критерий</li>
                            <li v-for="item in criterion" @click="select(item.id)">{{item.criterion}}</li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-success mt-3" @click="getData()">Сформировать отчет</button>
                </div>
            </div>
        </div>
        <div class="row" v-if="data">
            <div class="col">
                <div v-if="data"><b>Всего достижений за выбранный период: </b>{{counts.count_assessment}}</div>
                <div v-if="data"><b>Количество баллов за выбранный период: </b>{{counts.summary_points}}</div>
                <div class="card mb-3 mt-3" v-for="item in data">
                    <div class="card-header text-center">
                         <b>Сотрудник: </b> {{item.full_name}}
                    </div>
                    <div class="card-body">
                        <p><b>Критерий: </b> {{item.criterion}}</p>
                        <p><b>Критерии оценки: </b> {{item.criterion_assessment}}</p>
                        <p><b>Единица показателя: </b> {{item.unit_of_measure}}</p>
                        <p><b>Источник данных: </b> {{item.data_source}}</p>
                        <p><b>Периодичность подведения итогов: </b> {{item.summary_periodicity}}</p>
                        <p><b>Периодичность выплат: </b> {{item.frequency_of_payment}}</p>
                        <p><b>Количество баллов: </b> {{item.points}}</p>
                        <p><b>Вложения: </b> <a :href="item.attachment">Вложенный файл</a></p>
                        <p><b>Ответственный: </b> {{item.responsible}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            first_date: null,
            last_date: null,
            criterion: null,
            selected: '',
            data: null,
            counts: null,
            errors: {
                first_date: null,
                last_date: null,
                criterion: null
            }
        }),
        name: "assessmentReportManager",
        watch: {
            first_date(){
                this.getData()
            },
            last_date: function(){
                this.getData()
            },
            selected: function(){
                this.getData()
            }
        },
        methods: {
            getData() {
                if(!this.first_date) {
                    this.errors.first_date = 'Вы не выбрали дату!';
                    setTimeout(() => {
                        this.errors.first_date = null
                    }, 1500);
                    if (!this.selected) {
                        this.errors.criterion = 'Вы не выбрали критерий!';
                        setTimeout(() => {
                            this.errors.criterion = null
                        }, 1500)
                    }
                }
                if(this.first_date && this.selected.id) {
                    let params = {first_date:this.first_date, last_date:this.last_date, criterion:this.selected.id}
                    axios.get('/teacher/assessment/report/assessment-manager',{params})
                        .catch((error) => {console.log(error.response)})
                        .then(resp =>  {this.data = resp.data.data; this.counts = resp.data.counts;})
                }



            },
            select(id) {
                this.selected = Object.values(this.criterion).find(x => x.id === id);
            }
        },
        mounted() {
            axios.get('/teacher/assessment/report/get-criterion')
                .catch(error => console.log(error.response))
                .then(resp => {
                    this.criterion = resp.data
                });

            let items = $("ul#selectBox").children('li:not(.init)');
            $("ul#selectBox").on("click", ".init", function () {
                $(this).closest("ul#selectBox").children('li:not(.init)').toggle();
            });
            $("ul#selectBox").on("click", "li:not(.init)", function () {
                let items = $("ul#selectBox").children('li:not(.init)');
                items.removeClass('selected');
                $(this).addClass('selected');
                $("ul#selectBox").children('.init').html($(this).html());
                items.toggle();
            });
        }
    }
</script>

<style scoped>
    ul#selectBox {
        /*height: 30px;*/
        width: 500px;
        border: 1px #eaeaea solid;
        display: flex;
        flex-direction: column;
    }

    ul#selectBox li {
        padding: 5px 10px;
        z-index: 2;
    }

    ul#selectBox li:not(.init) {
        float: left;
        display: none;
        background: #42C5FF;
        color: #fff;
        /*text-shadow: 1px 1px 2.5px #383737;*/
    }

    ul#selectBox li:not(.init):hover {
        background: #1F9CD3;
        color: #000;
        cursor: pointer;
    }

    li.init {
        cursor: pointer;
    }

</style>
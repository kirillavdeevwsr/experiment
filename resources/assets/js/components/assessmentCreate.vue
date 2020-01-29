<template>
    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="errors mb-3 mt-3" v-if="messages.status == 400">
                    <div class="alert alert-danger alert-dismissible fade show text-center mt-3" role="alert"
                         v-for="(message, key) in messages.data">
                        <span v-html="message"></span>
                        <button type="button" class="close" aria-label="Close" @click="removeMessage(message)">
                            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                        </button>
                    </div>
                </div>

                <div class="errors mb-3 mt-3" v-else-if="messages.status == 200">
                    <div class="alert alert-success alert-dismissible fade show text-center mt-3" role="alert"
                         v-for="(message, key) in messages.data">
                        <span v-html="message"></span>
                        <button type="button" class="close" aria-label="Close" @click="removeMessage(message)">
                            <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                        </button>
                    </div>
                </div>


                <a href="../assessment" class="btn btn-secondary mb-2"> <i class="fas fa-arrow-left mr-3"></i>Вернуться назад</a>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><b>Критерий</b></label>
                            <div class="select">
                                <ul id="selectBox">
                                    <li class="init">Выберите критерий</li>
                                    <li @click="select(item.id)" v-for="item in data" class="option">
                                        {{item.criterion}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group" v-if="selected">
                            <label><b>Единица показателя</b></label>
                            <p v-html="selected.unit_of_measure"></p>
                        </div>
                        <div class="form-group" v-if="selected">
                            <label><b>Источник данных</b></label>
                            <p v-html="selected.data_source"></p>
                        </div>
                        <div class="form-group" v-if="selected">
                            <label><b>Периодичность подведения итогов</b></label>
                            <p v-html="selected.periodicity.name"></p>
                        </div>
                        <div class="form-group" v-if="selected">
                            <label><b>Периодичность выплат</b></label>
                            <p v-html="selected.frequency_payment.name"></p>
                        </div>
                        <div class="form-group" v-if="selected">
                            <label><b>Заполнение более одного раза за месяц</b></label>
                            <p v-if="Number(selected.multi_add) == 1">Да</p>
                            <p v-else>Нет</p>
                        </div>
                        <div class="form-group" v-if="selected">
                            <label><b>Вложения</b></label>
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" ref="file"
                                       @change="fileUpload()" lang="ru" autocomplete="false">
                                <label class="custom-file-label">{{formData.file ? formData.file.name : 'Выберите файл'}}</label>
                            </div>
                            <p>Выберите файл, подтверждающий ваши достижения</p>
                        </div>
                        <div v-if="selected && selected.multiple_select == 0" class="mb-3">
                            <p>Количество баллов</p>
                            <div class="form-check" v-for="item in selected.criterions">
                                <input class="form-check-input" type="radio" name="point" :id="`point_${item.id}`"
                                       :value="item.id" v-model="points.id_point" @input="selectPoint(item.id)">
                                <label class="form-check-label" :for="`point_${item.id}`">
                                    {{item.name}} - <b>{{item.point}}</b> балла (ов)
                                </label>
                            </div>
                        </div>

                        <div v-else-if="selected && selected.multiple_select == 1" class="mb-3">
                            <p>Количество баллов</p>
                            <div class="form-check" v-for="item in selected.criterions">
                                <input class="form-check-input" type="checkbox" name="point" :id="`point_${item.id}`"
                                       :value="item.id" v-model="points.point">
                                <label class="form-check-label" :for="`point_${item.id}`">
                                    {{item.name}} - <b>{{item.point}}</b> балла (ов)
                                </label>
                            </div>
                        </div>

                        <button class="btn btn-success btn-block" v-if="selected" @click="sendData()">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            data: null,
            selected: null,
            points: {
                id_point: null,
                point: []
            },
            formData: {
                criterion_id: null,
                file: null,
                points: null
            },
            messages: {status: null, data: null}
        }),
        props: {
            'csrf': String,
            'url': String,
        },
        name: "assessmentCreate",
        mounted() {
            this.initData();
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
        },
        methods: {
            initData() {
                fetch('create/init-data')
                .then((resp) => resp.json())
                .then((data) => {
                    this.data = data;
                });
            },
            select(id) {
                this.selected = Object.values(this.data).find(x => x.id === id);
                this.formData = {
                    criterion_id: this.selected.id,
                    file: null,
                    points: null
                }
                this.points = {id_point: null, point: []}
            },
            selectPoint(pointId) {
                const selectedPoint = this.selected.criterions.find((el) => {
                     return el.id === pointId;
                });
                this.points.point = selectedPoint.point;
                this.formData.points = this.points;
            },
            fileUpload() {
                this.formData.file = this.$refs.file.files[0];
            },
            removeMessage(name) {
                const index = this.messages.data.findIndex((el) => {
                    return el === name
                });
                this.messages.data.splice(index, 1);
            },
            sendData() {
                const fd = new FormData();
                if(this.selected.multiple_select == 1) {
                    this.formData.points = {
                        id_point: null,
                        point: null
                    };
                    this.points.point.forEach((el) => {
                        let a = parseFloat(this.selected.criterions.find((item) => {
                            return item.id == el;
                        }).point);
                        this.formData.points.point += a;
                    })
                }
                fd.append('criterion', this.formData.criterion_id);
                if(this.formData.file !== null)fd.append('file', this.formData.file);
                if(this.formData.points !== null)fd.append('points', JSON.stringify(this.formData.points));
                fetch(this.url, {
                    method: 'post',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: fd
                }).then((resp) => {
                    this.messages.status = resp.status;
                    return resp.json();
                }).then((data) => {
                    this.messages.data = data;
                    if(this.messages.status === 200) {
                        this.formData = null;
                        this.selected = null;
                        this.initData();
                    }
                });
            }
        },
    }
</script>

<style scoped>
    ul#selectBox {
        /*height: 30px;*/
        /*width: 500px;*/
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
        background: #fff;
        color: #000;
        text-align: start;
        border-bottom: 1px solid #eaeaea;
        /*text-shadow: 1px 1px 2.5px #383737;*/
    }

    ul#selectBox li:not(.init):hover {
        background: #bdebff;
        color: #000;
        cursor: pointer;
    }

    li.init {
        cursor: pointer;
    }
</style>
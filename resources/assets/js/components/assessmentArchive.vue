<template>
    <div class="container mb-3 mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header text-center">
                        Архив отправленных критериев
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Выберите отчетный период</label>
                            <input type="month" class="form-control" v-model="period">
                            <p class="text-danger" v-if="periodError">Вы не выбрали отчетный период!</p>
                        </div>
                        <button class="btn btn-outline-success" @click="getData()">Сформировать</button>

                        <div class="row mt-3 mb-3" v-if="data">
                            <div class="col-md-12 col-sm-12">
                                Итого подтвержденных баллов: {{parseFloat(this.data.acceptedPoint).toFixed(2)}}
                            </div>
                            <div class="col-md-12 col-sm-12">
                                Итого неподтвержденных баллов: {{parseFloat(this.data.notAcceptedPoint).toFixed(2)}}
                            </div>
                            <div class="col-md-12 col-sm-12">
                                Итого отклоненных баллов: {{parseFloat(this.data.declinedPoint).toFixed(2)}}
                            </div>
                        </div>
                        <div class="row" v-if="data">
                            <div class="col">
                                <div class="table-responsive-md">
                                    <table class="table table-borderless">
                                        <thead>
                                        <th scope="col">#</th>
                                        <th scope="col">Критерий</th>
                                        <th scope="col">Балл</th>
                                        <th scope="col">Вложения</th>
                                        <th scope="col">Статус</th>
                                        <th scope="col">Комментарий</th>
                                        <th scope="col">Дата отправки</th>
                                        <th scope="col">Дата изменения</th>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.data" :class="`table-${item.status_color}`">
                                            <th scope="row">{{index + 1}}</th>
                                            <td>{{item.assessment.criterion}}</td>
                                            <td>{{parseFloat(item.point).toFixed(2)}}</td>
                                            <td><a :href="`${item.attachment}`">{{item.attachment.split('/')[2]}}</a>
                                            </td>
                                            <td>{{item.status.name}}</td>
                                            <td>{{item.description}}</td>
                                            <td style="width: 12%">{{item.created_at}}</td>
                                            <td style="width: 12%">{{item.updated_at}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="text-center"><b>Критерии, заполняемые раз в
                                                семестр</b></td>
                                        </tr>
                                        <tr v-for="(item, index) in data.dataSem" :class="`table-${item.status_color}`">
                                            <th scope="row">{{index + 1}}</th>
                                            <td>{{item.assessment.criterion}}</td>
                                            <td>{{parseFloat(item.point).toFixed(2)}}</td>
                                            <td><a :href="`${item.attachment}`">{{item.attachment.split('/')[2]}}</a>
                                            </td>
                                            <td>{{item.status.name}}</td>
                                            <td>{{item.description}}</td>
                                            <td style="width: 12%">{{item.created_at}}</td>
                                            <td style="width: 12%">{{item.updated_at}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                        <div class="row justify-content-center" v-if="data == null && !issetData">
                            <h3>Нет данных!</h3>
                        </div>
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
            period: null,
            periodError: false,
            loadingData: false,
            issetData: true,
        }),
        watch: {
            period() {
                if (this.period != '')
                    this.getData()
            }
        },
        props: {
            url: String
        },
        methods: {
            getData() {
                if (this.period != '') {
                    this.periodError = false;
                    this.loadingData = true;
                    this.issetData = true;
                    this.data = null;
                    fetch(this.url + `?period=${this.period}`)
                        .then((response) => {
                            if (response.status == 200) {
                                response.json().then((data) => {
                                    this.data = data;
                                    this.loadingData = false;
                                })
                            } else {
                                this.data = null;
                                this.issetData = false;
                                this.loadingData = false
                            }
                        })
                } else {
                    this.periodError = true;
                }
            }
        }
    }
</script>

<style scoped>

</style>
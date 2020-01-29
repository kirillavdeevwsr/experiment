<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Выберите месяц</label>
                    <input type="month" class="form-control" v-model="month">
                    <p class="text-danger">{{errors.month}}</p>
                    <button class="btn btn-outline-success mt-3" @click="getData()">Сформировать отчет</button>
                </div>
            </div>
        </div>
        <div v-if="data">
            <div class="text-right mb-2"><p><b>Всего баллов по организации: {{parseFloat(data.summary_points).toFixed(2)}}</span></b>
            </p></div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">№п/п</th>
                    <th scope="col">Сотрудник</th>
                    <th scope="col">Баллов за месяц</th>
                </tr>
                </thead>
                <tbody v-if="data">
                <tr v-for="(item, index) in data.data">
                    <th scope="row">{{index+1}}</th>
                    <th scope="row">{{item.full_name}}</th>
                    <th scope="row">{{parseFloat(item.points).toFixed(2)}}</th>
                </tr>
                </tbody>
            </table>
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
</template>

<script>
    export default {
        data: () => ({
            month: null,
            errors: {
                month: null
            },
            data: null,
            loadingData: false,
            issetData: true,
        }),
        name: "AssessmentReportAccountant",
        watch: {
            month: function () {
                this.getData();
            }
        },
        methods: {
            getData() {
                this.errors.month = null;
                if (!this.month) {
                    this.errors.month = "Необходимо выбрать месяц и год!";
                    this.data = null;
                    setTimeout(() => {
                        this.errors.month = null
                    }, 1500);
                } else {
                    let params = {month: this.month};
                    this.loadingData = true;
                    this.issetData = true;
                    this.data = null;
                    fetch('/teacher/assessment/report/accountant?month=' + this.month)
                    .then((resp) => {
                        if(resp.status == 200) {
                            resp.json().then((data) => {
                                this.data = data;
                                this.loadingData = false;
                            });
                        }else {
                            this.data = null;
                            this.loadingData = false;
                            this.issetData = false;
                        }
                    })
                    // axios.get('/teacher/assessment/report/accountant', {params})
                    //     .catch((error) => console.log(error.response))
                    //     .then(resp => this.data = resp.data);
                }
            }
        }
    }
</script>

<style scoped>

</style>
<template>
    <div class="row justify-content-center">
        <div class="col-5">
            <div class="row">
                <div class="col">concept</div>
                <div class="col">title</div>
                <div class="col">participants</div>
                <div class="col">responsible</div>
                <div class="col">place</div>
                <div class="col">date</div>
            </div>

            <div class="border row" v-for="el in date">
                <textarea class="form-control col">{{el.concept_id}}</textarea>
                <textarea class="form-control col">{{el.title}}</textarea>
                <textarea class="form-control col">{{el.participants}}</textarea>
                <textarea class="form-control col">{{el.responsible}}</textarea>
                <textarea class="form-control col">{{el.place}}</textarea>
                <div class="col">{{el.date}}</div>
            </div>
        </div>
        <div class="w-100"></div>
        <button v-on:click="send">Сохранить</button>
    </div>


</template>

<script>
    export default {
        name: "test",
        data: function () {
            return {
                date: '',
            }
        },
        created: function () {
            $.ajax({
                url: 'http://experiment/admin/delefile/journal/bringOut',
                type: 'POST',
                data: {},
                success: (e) => {
                    for (let i = 0; i < e[0].length; i++) {
                        e[0][i].concept_id
                        for (let r = 0; r < e[1].length; r++) {
                            if (e[0][i].concept_id == e[1][r].concept_id) {
                                e[0][i].concept_id = e[1][r].name
                            }
                        }
                    }
                    this.date = e[0]
                }
            })
        },
        methods: {
            send: function () {
                axios({
                    method:'GET',
                    url:'http://experiment/admin/delefile/journal/export',
                    responseType: 'blob',
                }).then((response)=>{
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    let link = document.createElement('a');
                    link.href = url;
                    const fileName = response.headers['content-disposition'].split('=')[1];
                    link.setAttribute('download', fileName);
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                })
            }
        }
    }
</script>

<style scoped>

</style>
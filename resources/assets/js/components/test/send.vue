<template>
    <div>



<div class="form">
    <div class="form-group">
        <label>Направление:</label>
        <select v-model="select" class="col-3">
            <option value="">-- Выберите направление --</option>
            <option v-for="el in concept" :value="el.id">{{el.name}}</option>
        </select>
    </div>
    <div class="form-row">
        <div class="form-group col">
            <label for="titleInput">Заголовок:</label>
            <input type="text" class="form-control" id="titleInput" placeholder="Введите заголовок" v-model="title">
        </div>
        <div class="form-group col">
            <label for="participantsInput">Участники:</label>
            <input type="text" class="form-control" id="participantsInput" placeholder="Введите Участников" v-model="participants">
        </div>
        <div class="form-group col">
            <label for="responsibleInput">Ответственые:</label>
            <input type="text" class="form-control" id="responsibleInput" placeholder="Введите Ответствены[" v-model="responsible">
        </div>
    </div>



</div>





        <div class="row justify-content-center">
            <div class="col-1">responsible</div>
            <input v-model="responsible" class="col-3">
            <div class="w-100"></div>
            <div class="col-1">place</div>
            <input v-model="place" class="col-3">
            <div class="w-100"></div>
            <div class="col-1">date</div>
            <input v-model="date" type="date" class="col-3">
            <div class="w-100"></div>
            <div class="col-1">description</div>
            <textarea class="form-control col-3" aria-label="With textarea " v-model="description"></textarea>
            <div class="w-100"></div>
            <button v-on:click="send">Сохранить</button>
        </div>

        <div id="menu" class="">


        </div>
    </div>
</template>

<style>
    #menu {
        display: flex;
    }
</style>

<script>
    export default {
        name: "send",
        data: function () {
            return {
                select: '',
                participants: '',
                responsible: '',
                place: '',
                date: '',
                description: '',
                title: '',
                concept: '',
            }
        },
        created: function () {
            $.ajax({
                url: 'http://experiment/admin/delefile/journal/save',
                type: 'GET',
                success: (e) => {
                    this.concept = e;
                }
            })
        },
        methods: {
            send: function () {
                $.ajax({
                    url: 'http://experiment/admin/delefile/journal/save',
                    type: 'POST',
                    data: {
                        'concept_id': this.select,
                        'participants': this.participants,
                        'responsible': this.responsible,
                        'place': this.place,
                        'date': this.date,
                        'description': this.description,
                        'title': this.title,
                    },
                    success:(e)=>{
                        console.log(e)
                        this.participants = '';
                        this.responsible = '';
                        this.place = '';
                        this.date = '';
                        this.description = '';
                        this.title = '';
                        if(e){
                            alert('Сохранено')
                        }
                    }
                })

            }
        },
    }
</script>




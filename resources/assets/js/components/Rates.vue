<template>
        <div class="container">
            <div  class="ocenki-month">
                <a href="#"
                @click.prevent="getDays(month-1)"
                   :class = "{'hidden-a': ifLastYear()}">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px"
                     viewBox="0 0 492 492" style="enable-background:new 0 0 492 492;" xml:space="preserve" width="10px" height="10px">
                    <g>
                        <g>
                            <path d="M198.608,246.104L382.664,62.04c5.068-5.056,7.856-11.816,7.856-19.024c0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12    C361.476,2.792,354.712,0,347.504,0s-13.964,2.792-19.028,7.864L109.328,227.008c-5.084,5.08-7.868,11.868-7.848,19.084    c-0.02,7.248,2.76,14.028,7.848,19.112l218.944,218.932c5.064,5.072,11.82,7.864,19.032,7.864c7.208,0,13.964-2.792,19.032-7.864    l16.124-16.12c10.492-10.492,10.492-27.572,0-38.06L198.608,246.104z"
                            />
                        </g>
                    </g>
                </svg>
                </a>
                <span class="ocenki-month-name">{{rusMonth[month]}}, {{year}}</span>
                <a href="#"
                   @click.prevent="getDays(month+1)"
                   :class = "{'hidden-a': ifCurDate()}"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                     width="10px" height="10px" viewBox="0 0 451.846 451.847" style="enable-background:new 0 0 451.846 451.847;" xml:space="preserve">
                    <g>
                        <path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744   L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284   c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z"
                        />
                    </g>
                </svg>
                </a>
            </div>
            <div  v-if ='isLoading'>Загружаю данные...</div>

            <div  v-else class="ocenki-table">
                <table >
                    <tr>
                        <th>№ П.П.</th>
                        <th>Предмет</th>
                        <th class="ocenki-items" :colspan="m">Оценки</th>
                    </tr>

                    <tr>
                        <th colspan="2">Дата</th>
                        <td v-for="day in daysMonth">{{day}}</td>
                    </tr>

                    <tr v-for ="(data, index) in rates">
                        <td>{{index}}</td>
                        <td></td>
                        <td class="rate" v-for="day in daysMonth">
                            <span v-for ="(v , k) in data">
                             <span v-if="day == k">
                                 <span v-for="dis in v">
                                     {{dis.rate}} <p class="rate-type">{{dis.type}}</p>

                             </span>
                            </span>
                            </span>

                        </td>
                    </tr>



                </table>

            </div>
        </div>









</template>

<script>
    const rusMonth = [
        'Январь', 'Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь',
    ];

    export default {
        name: "ocenki-month",

        data: () => ({
            isLoading : false,
            rates:[],
            m: 0,
            daysMonth:[],
            rusMonth:rusMonth,
            month:0,
            year:'',
            now: new Date(),


       }),
        created(){
            this.init();
        },
        methods: {
            async init() {
                //получаю количество дней в текущем месяце
                Date.prototype.daysInMonth = function () {
                    return 32 - new Date(this.getFullYear(), this.getMonth(), 32).getDate();
                };
                this.m = this.now.daysInMonth();
                //формирую массив с днями месяца

                this.month = this.now.getMonth();
                this.year = this.now.getFullYear();
                this.getRates(this.month);
                this.dayInMonthFunc(this.m);


            },
            async getRates(month){
                this.isLoading = true;
                const rate = await axios.get('/profile/getrate', {data:month+1}
                ).catch((error) => console.log(error.response.data));
                this.rates = rate.data;
                this.isLoading = false;


            },

            //все следующие разы получаю дни месяца с бекенда
            async getDays(month){
                //получить оценки
                const params = {data:month};
                const days = await axios.get('/profile/getmonthdata', { params }
                ).catch((error) => console.log(error.response.data));
                this.m = days.data;
                this.dayInMonthFunc(this.m);
                this.month = month;
                this.getRates(month);
            },
            dayInMonthFunc(mo){
                this.daysMonth = Array.from(new Array(mo), (val, index) => index + 1);
            },

            ifCurDate(){
              if((this.now.getMonth() == this.month && this.now.getFullYear() == this.year) || this.now.getFullYear() <= this.year-2 ){
                  return true;
              }else{
                  return false;
              }
            },
            ifLastYear(){
                if(this.month ===0){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }
</script>

<style>
    .rate{
        text-align: center;
    }
    .rate-type{
        font-size: 10px;
        color: #00c5ff;

    }


</style>
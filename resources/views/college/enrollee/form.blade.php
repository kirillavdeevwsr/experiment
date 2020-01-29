@extends('layouts.index')
@section ('title')Отправить заявку@endsection
@section ('content')

    <section id="zayavlenieAbitur">
    <div class="container zayavka" id="zayavka">
        <h2>Заявление абитуриента</h2>
        @if(session('mess'))
            <div><h2 style="color: darkred;">{{session('mess')}}</h2></div>
        @endif
        <h3>
            Форма заявления
        </h3>
        <form action="{{route('sendData')}}" method="post">
            {{csrf_field()}}
            <p>Информация о себе</p>
            <div class="info-about-me">
                <div class="item">
                <label for="secondname">Фамилия</label>
                <input required type="text" name="secondname">


                <label for="firstname">Имя</label>
                <input  type="text" name="firstname">

                <label for="lastname">Отчество</label>
                <input required type="text" name="lastname">

                <label for="documentType">Вид документа</label>
                <select name="documentType" type="text">
                        <option value="Удостоверение беженца в Российской Федерации">Удостоверение беженца в Российской Федерации</option>
                        <option value="Свидетельство о рождении">Свидетельство о рождении</option>
                        <option value="Иные документы">Иные документы</option>
                        <option value="Военный билет солдата (матроса, сержанта, старшины)">Военный билет солдата (матроса, сержанта, старшины)</option>
                        <option value="Справка об освобождении из места лишения свободы">Справка об освобождении из места лишения свободы</option>
                        <option value="Временное удостоверение личности гражданина Российской Федерации">Временное удостоверение личности гражданина Российской Федерации</option>
                        <option value="Удостоверение личности офицера">Удостоверение личности офицера</option>
                        <option value="Загранпаспорт гражданина СССР">Загранпаспорт гражданина СССР</option>
                        <option value="Дипломатический паспорт гражданина Российской Федерации">Дипломатический паспорт гражданина Российской Федерации</option>
                        <option value="Разрешение на временное проживание в Российской Федерации">Разрешение на временное проживание в Российской Федерации</option>
                        <option value="Паспорт гражданина СССР">Паспорт гражданина СССР</option>
                        <option value="Паспорт Минморфлота">Паспорт Минморфлота</option>
                        <option value="Свидетельство о рождении, выданное уполномоченным органом иностранного государства">Свидетельство о рождении, выданное уполномоченным органом иностранного государства</option>
                        <option value="Вид на жительство">Вид на жительство</option>
                        <option value="Паспорт моряка">Паспорт моряка</option>
                        <option value="Загранпаспорт гражданина Российской Федерации">Загранпаспорт гражданина Российской Федерации</option>
                        <option value="Военный билет офицера запаса">Военный билет офицера запаса</option>
                        <option value="Паспорт гражданина Российской Федерации">Паспорт гражданина Российской Федерации</option>
                        <option value="Свидетельство о рассмотрении ходатайства о признании беженцем на территории Российской Федерации по существу">Свидетельство о рассмотрении ходатайства о признании беженцем на территории Российской Федерации по существу</option>
                        <option value="Паспорт иностранного гражданина">Паспорт иностранного гражданина</option>
                    </select>

                    <label for="documentSerial">Серия</label>
                    <input required type="text" name="documentSerial">

                    <label for="documentNumber">Номер</label>
                    <input required type="text" name="documentNumber">

                </div>
                <div class="item">
                    <label for="sex">Пол</label>
                    <select name="sex">
                        <option value="Женский">Женский</option>
                        <option value="Мужской">Мужской</option>
                    </select>

                    <label for="birthday">Дата рождения</label>
                    <input required type="date" name="birthday">

                    <label for="phone">Телефон</label>
                    <input type="tel" required name="phone">

                    <label for="documentEx">Кем выдан</label>
                    <input required type="text" name="documentEx">

                    <label for="documentDate">Дата выдачи</label>
                    <input required type="date" name="documentDate">

                    <label for="documentCode">Код подразделения</label>
                    <input required type="text" name="documentCode">
                </div>
                <div class="item">
                    <label for="education">Полученное образование</label>
                    <select type="text" name="education">
                        <option value="ДошкольноеОбразование">Дошкольное образование</option>
                        <option value="НачальноеОбщееОбразование">Начальное общее образование</option>
                        <option value="ОсновноеОбщее">Основное общее образование</option>
                        <option value="СреднееОбщее">Среднее общее образование</option>
                        <option value="СреднееПрофессиональное">Среднее профессиональное образование</option>
                        <option value="Бакалавриат">Высшее профессиональное образование - бакалавриат</option>
                        <option value="Магистратура">Высшее профессиональное образование - специалитет, магистратура</option>
                        <option value="ПослевузовскоеПрофессиональное">Высшее образование - подготовка кадров высшей квалификации</option>
                        <option value="ДополнительноеПрофессиональноеОбразование">Дополнительное профессиональное образование</option>
                        <option value="ДополнительноеОбразованиеДетейИВзрослых">Дополнительное образование детей и взрослых</option>
                        <option value="НачальноеПрофессиональное">Начальное профессиональное образование (в настоящий момент не применяется!)</option>
                    </select>

                <label for="speciality">Основная специальность</label>
                <select type="text" name="speciality">
                    <option value="0">Выбрать</option>
                    @foreach ($specialities as $speciality)
                        <option value="{{$speciality->id}}">{{$speciality->name}}</option>
                        @endforeach

                </select>

                <label for="speciality">Дополнительная специальность</label>
                <select type="text" name="speciality1">
                    <option value="0">Выбрать</option>
                    @foreach ($specialities as $speciality)
                        <option value="{{$speciality->id}}">{{$speciality->name}}</option>
                        @endforeach

                </select>

                <label for="speciality">Дополнительная специальность</label>
                <select type="text" name="speciality2">
                    <option value="0">Выбрать</option>
                    @foreach ($specialities as $speciality)
                        <option value="{{$speciality->id}}">{{$speciality->name}}</option>
                        @endforeach

                </select>

                </div>
            </div>

            <p>Адрес по прописке</p>
            <div class="adressPoProp">

                <div class="item">

                    <label for="state">Республика, край или область</label>
                    <input required name="state" type="text" placeholder="Республика Башкортостан">

                    <label for="index">Индекс</label>
                    <input required name="index" type="number">

                    <label for="city">Название населенного пункта</label>
                    <input required name="city" type="text">

                    <label for="street">Улица</label>
                    <input required type="text" name="street">
                </div>

                <div class="item">
                    <label for="house">Номер дома</label>
                    <input required name ='house' type="number">

                    <label for="sub">Корпус или дробь</label>
                    <input name ='sub' type="text">

                    <label for="flat">Квартира</label>
                    <input type="number" name='flat'>
                </div>
            </div>

            <p>Адрес проживания</p>
            <div class="adressProzh">

                <div class="item">

                    <label for="state1">Республика, край или область</label>
                    <input required name="state1" type="text" default="Республика Башкортостан">

                    <label for="index1">Индекс</label>
                    <input required name="index1" type="number">

                    <label for="city1">Название населенного пункта</label>
                    <input required name="city1" type="text">

                    <label for="street1">Улица</label>
                    <input required type="text" name="street1">
                </div>

                <div class="item">
                    <label for="house1">Номер дома</label>
                    <input required name ='house1' type="number">

                    <label for="sub1">Корпус или дробь</label>
                    <input name ='sub1' type="text">

                    <label for="flat1">Квартира</label>
                    <input type="number" name='flat1'>
                </div>
            </div>

             <label for="option"><span>
                 </span><input type="checkbox" name="checkbox" id="personal_data" value="0" required> Я даю согласие на обработку <a href="files/personal_data.pdf">моих персональных данных </a>
            </label>
            @if(session('message'))
                <p>You are a bot! Go away!</p>
                @endif
            <div class="capcha">
            <div class="g-recaptcha" data-sitekey="6LftgWMUAAAAANbt3W007g0MwEYQINEoGwKwM6Q4"></div>
            </div>
            <button class="about-btn" id="btnCheck">Отправить</button>
        </form>

    </div>
    </section>
    @endsection
<style>

</style>

jQuery.validator.addMethod("checkMask", function(value, element) {
     return /\+\d{1}\(\d{3}\)\d{3}-\d{4}/g.test(value); 
});

$('#courses_sing_up').validate({
rules: {
  name: {
	required: true,
	minlength: 3
  },
  phone: {
	required: true,
	checkMask: true
  }
},
messages: {
  name: {
	required: "Поле 'Полное имя' обязательно к заполнению",
	minlength: "Введите не менее 3-х символов в поле 'Полное имя'"
  },
  phone: {
	required: "Поле 'Телефон' обязательно к заполнению",
	phone: "Необходим формат телефона",
	checkMask: "Введите полный номер телефона"
  }
}
});
$('input[name="phone"]').mask("+7(999)999-9999", {autoclear: false});


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<input type="text" class="myInput1" id="myInput1" />
<input type="text" class="myInput2" id="myInput2" />
<input type="text" id="myInput3" />

</body>
</html>

<script type="text/javascript">
  var input1 = document.getElementById('myInput1');
  var input2 = document.getElementById('myInput2');
  var input3 = document.getElementById('myInput3');

  input2.addEventListener('change','.myInput1','.myInput2', function() {
    input3.value = input1.value *input2.value ;
  });
</script>
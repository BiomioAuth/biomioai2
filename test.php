<!DOCTYPE html>
<html>
<head>
    <title>Title</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="header">

</div>

<div class="container">
    <div class="row">
      <form class="form">
      	<h2>POST</h2>
      	<div class="form-group">
			<label class="col-sm-3 control-label">Link</label>
			<div class="col-sm-9">
				<input type='text' class="form-control link-1">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<button class="pull-right btn btn-success send-1">Send</button>
			</div>
		</div>
      </form>

      <form class="form">
      	<h2>GET</h2>
      	<div class="form-group">
			<label class="col-sm-3 control-label">Link</label>
			<div class="col-sm-9">
				<input type='text' class="form-control link-2">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<button class="pull-right btn btn-success send-2">Send</button>
			</div>
		</div>
      </form>
    </div>
</div>

<div class="footer hide">
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="js/libs/bootstrap.min.js"></script>

<script>
$(document).on('click touchend', ".rate-nav, .send-1", function (e) {
  e.preventDefault();
  var url = $('.link-1').val();
  var data = $('.json-1').val();

  var fingerprints = {};
  for (i = 0; i < 10; i++)
    fingerprints[i] = 1;

  var data = {};
  data['probe_id'] = 123412341234;

  $.ajax({
        url: url,
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(data) {

        },
        error: function(data) {
          console.log('error');
        }
    });
});

$(document).on('click touchend', ".rate-nav, .send-2", function (e) {
  e.preventDefault();
  var url = $('.link-2').val();
  var data = $('.json-2').val();

  $.ajax({
        url: url,
        type: 'GET',
        dataType: "json",
        data: data,
        success: function(data) {

        },
        error: function(data) {
          console.log('error');
        }
    });
});
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="author" content="Martin Bean" />
    <title>HTTP Client</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/js/google-code-prettify/prettify.css" />
    <style>
        .modal img {
            display: block;
            margin: 50px auto;
        }
    </style>
  </head>
  <body>
    <div class="container">
      <header class="page-header">
        <h1>HTTP Client</h1>
      </header>
      <h2>Request</h2>
      <p class="alert alert-error"><?php echo $error; ?></p>
      <form method="post" action="">
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="url">URL</label>
            <div class="controls">
              <input type="url" name="url" id="url" class="span12" placeholder="http://" />
            </div>
          </div>
          <div class="control-group" id="parameters">
            <label class="control-label">Parameters</label>
            <div class="row">
              <div class="span6">
                <input type="text" name="parameters[keys][]" class="span6" />
              </div>
              <div class="span5">
                <input type="text" name="parameters[values][]" class="span5" />
              </div>
              <div class="span1">
                <button class="btn btn-primary btn-add">
                  <span class="icon-white icon-plus"></span>
                </button>
              </div>
            </div>
          </div>
        </fieldset>
        <fieldset class="form-actions">
          <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
        </fieldset>
      </form>
      <h2>Response</h2>
      <pre class="prettyprint linenums" id="response"></pre>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="assets/js/google-code-prettify/prettify.js"></script>
    <script>
        (function($) {
            $('.alert-error').hide();
            $('.btn-add').live('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var row = $(this).closest('.row');
                row.clone().insertAfter($('.row:last'));
                button.removeClass('btn-primary')
                      .removeClass('btn-add')
                      .addClass('btn-danger')
                      .addClass('btn-remove')
                      .find('span')
                      .removeClass('icon-plus')
                      .addClass('icon-trash');
            });
            $('.btn-remove').live('click', function(e) {
                e.preventDefault();
                var row = $(this).closest('.row');
                if (confirm('Are you sure?')) {
                    row.remove();
                }
            });
            $('form').on('submit', function(e) {
                e.preventDefault();
                $.post('index.php', $('form').serialize(), function(response) {
                    $('.alert-error').fadeOut('fast');
                    if (response.error) {
                        $('.alert-error').text(response.error.message).fadeIn('fast');
                    }
                    else {
                        $('#response').text(response.result);
                        prettyPrint();
                    }
                });
            });
        })(jQuery);
    </script>
  </body>
</html>
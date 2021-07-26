// Ajax data collect

// step 1: build data structure
var data = {
    metros: [1,2,3],
    routes: [10,20,30,40,50]
}

// step 2: convert data structure to JSON
$.post({
    url : 'ajax.php',
    data : {
        json : JSON.stringify(data)
    },
    success: function(response) {
        console.log('AJAX POST');
    }
});

$.get({
    url : 'data.json',
    success: function(response) {
        console.log('AJAX GET');
        console.log(response);
    }
});

// AJAX get post
function getPosts(args = {}) {
  $('.js-posts-wrap').addClass('loading');

  $.post({
    url: ajax_front.url,
    data: {
      _ajax_nonce: ajax_front.nonce,
      action: 'mc_get_posts_template',
      args,
    },
    success: function (response) {
      if (response) {
        $('.js-posts-wrap').html(response);
        $('.js-posts-wrap').removeClass('loading');
      } else {
        console.error('WP AJAX error');
      }
    },
    error: function (error) {
      console.error(error);
    },
  });
}

// AJAX message
function sendMessage(target) {
  let form = $(target);
  let trigger = form.find('button[type="submit"]');
  let data = form.serialize();

  // console.log(data);

  trigger.prop('disabled', true);

  $.post({
    url: ajax_front.url,
    data: {
      _ajax_nonce: ajax_front.nonce,
      action: 'send_message',
      data,
    },
    success: function (response) {
      if (response === 'success') {
        window.location.href = '/spasibo-za-vashu-zayavku/';
      } else {
        console.error(response);
      }
    },
    error: function (error) {
      console.error(error);
    },
    complete: function () {
      trigger.removeAttr('disabled');
    },
  });
}

$('.js-order').on('submit', function (event) {
  event.preventDefault();
  sendMessage(event.target);
});
var ccal_current_event_id = 0;
function ccal_viewEvent(rest_url, event_id) {
  ccal_current_event_id = event_id;
  ccal_setDisplayClass("ccal-list", "none");
  ccal_setDisplayClass("ccal-loading", "block");

  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      ccal_handleEventData(JSON.parse(this.responseText));
    }
  };
  xhttp.open("POST", rest_url, true);
  xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
  xhttp.send("post_id=" + event_id + "&action=ccal_get_event");
}

function ccal_viewList() {
  ccal_setDisplayClass("ccal-list", "block");
  ccal_setDisplayClass("ccal-event", "none");
}

function ccal_setDisplayClass(class_name, display_value) {
  let e = document.getElementsByClassName(class_name);
  if (e) {
    e[0].style.display = display_value;
  }
}

function ccal_handleEventData(data) {
  if (!data.success) {
    console.error(data);
    alert("Sorry, irgendwas ist schief gelaufen!")
    return ccal_viewList();
  }

  document.getElementById("ccale_title").innerHTML = data.data.title;
  document.getElementById("ccale_date").innerHTML = data.data.event_date;
  document.getElementById("ccale_content").innerHTML = data.data.content;
  ccal_setOwnStatus(data.data.own_status);
  ccal_genUserStatus(data.data.event_users);

  ccal_setDisplayClass("ccal-loading", "none");
  ccal_setDisplayClass("ccal-event", "block");
}

function ccal_setAvailability(rest_url, status)
{
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      let data = JSON.parse(this.responseText);
      if (!data.success) {
        console.error(data);
        alert("Sorry, irgendwas ist schief gelaufen!")
        return;
      }
      ccal_setOwnStatus(status);
    }
  };
  xhttp.open("POST", rest_url, true);
  xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
  xhttp.send("post_id=" + ccal_current_event_id + "&user_status=" + status + "&action=ccal_set_status");
}

function ccal_setOwnStatus(status)
{
  var inner_text = "keine";
  var span_class = "";
  if (status == 1) {
    inner_text = "zugesagt";
    span_class = "green";
  } else if (status == 2) {
    inner_text = "unsicher";
    span_class = "amber";
  } else if (status == 3) {
    inner_text = "abgesagt";
    span_class = "red";
  }

  let element = document.getElementById("ccale_answer");
  if (element) {
    element.innerHTML = '<span class="' + span_class + '">' + inner_text + '</span>';
  }
}
function ccal_getStatusSpan(username, status)
{
  var span_class = "";
  if (status == 1) {
    span_class = "green";
  } else if (status == 2) {
    span_class = "amber";
  } else if (status == 3) {
    span_class = "red";
  }
  return '<span class="' + span_class + '">' + username + '</span>';
}
function ccal_genUserStatus(event_users)
{
  var html = "";
  for (let user in event_users)
  {
    html += ccal_getStatusSpan(user, event_users[user]) + ", ";
  }
  document.getElementById("ccale_users").innerHTML = html;
}

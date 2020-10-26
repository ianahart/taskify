const slider = document.querySelector('.slider');
const timeToComplete = document.querySelector('span');
const times = document.querySelectorAll('.time');
const cancelEditBtns = document.querySelectorAll('.cancel-edit');
const editIcons = document.querySelectorAll('.edit-icon-container');
const editForms = document.querySelectorAll('.edit-form');
const modals = document.querySelectorAll('.modal');

const showToolTip = (e) => {

  const toolTip = e.target.firstElementChild;
  toolTip.classList.remove('hidden');
}


const hideToolTip = (e) => {
    const toolTip = e.target.firstElementChild;
  toolTip.classList.add('hidden');
}


const clearError = (error) => {
  error.textContent = '';
}

const handleEditErrors = (e) => {

  const form = e.target;
  const titleInput = form.querySelector('input[name="edit_title"]');
  const descriptionInput = form.querySelector('input[name="edit_description"]');

  const descriptionError = form.querySelector('.description-error');
  const titleError = form.querySelector('.title-error');

  titleInput.addEventListener('change', () => {
    clearError(titleError);
  });

  descriptionInput.addEventListener('change', () => {
    clearError(descriptionError);
  })


  if (titleInput.value.length === 0) {
    titleError.textContent = 'Please Provide a title';
  } else if (titleInput.value.length < 6) {
    titleError.textContent = 'Title must be a minimum of 6 characters';
  } else if (titleInput.value.length > 35) {
    titleError.textContent = 'Title must not exceed 35 characters';
  } else if (/[!"#$%&'()*+.\/:;<=>?@\[\\\]^_`{|}~-]/.test(titleInput.value)) {
    titleError.textContent = 'Please exclude special characters in the title';
  } else {
    titleError.textContent = '';
  }



  if (descriptionInput.value.length === 0) {
    descriptionError.textContent = 'Please provide a description';
  } else if (descriptionInput.value.length < 6) {
    descriptionError.textContent = 'Description must be a minimum of 6 characters';
  } else if (descriptionInput.value.length > 50) {
    descriptionError.textContent = 'Description must not exceed 50 characters';
  } else {
    descriptionError.textContent = '';
  }
  console.log(titleError.textContent);
  if (titleError.textContent === '' && descriptionError.textContent === '') {
    form.submit();
  } else {
    e.preventDefault();
  }




}


editIcons.forEach((editIcon) => {
  editIcon.addEventListener('mouseenter', showToolTip);
  editIcon.addEventListener('mouseleave', hideToolTip);
});


editForms.forEach((editForm) => {
  editForm.addEventListener('submit', handleEditErrors);
});





const openModal = (e) => {
  const modal = e.target.parentElement.parentElement.parentElement.previousElementSibling;

  modal.classList.remove('hidden');
}

const closeModal = (e) => {
    const modal = e.target.closest('.modal');
    modal.classList.add('hidden');

}

editIcons.forEach((editIcon) => {
  editIcon.addEventListener('click', openModal);
});

cancelEditBtns.forEach((btn) => {
  btn.addEventListener('click', closeModal);
});



const trackSlider = (e) => {
  const numOfdays = e.target.value;

  if (numOfdays === 1) {

    timeToComplete.textContent = `${numOfdays} day`;

  } else {

    timeToComplete.textContent = `${numOfdays} days`;

  }
}

slider.addEventListener('change', trackSlider);



const initTimer = (time) => {

  let days;
  let minutes;
  let seconds;
  let hours;
  let message;

  const dayAmount = time.dataset.timer.split('d')[0];

  if (dayAmount === '10') {
     days = dayAmount - 1;
     hours = 23;
     minutes = 59;
     seconds = 59;
  }
   else if(time.dataset.timer.split('0').length - 1 === 3) {
    if(dayAmount === '1') {

      days = 0;
    } else if(dayAmount > '1') {

      days = dayAmount -1;
    }

    hours = 23;
    minutes = 59;
    seconds = 59;

  } else {

    let values = time.dataset.timer.split('').filter((val) => {
      if (!isNaN(val)) {
        return val;
      }
    })

    values = values.join('').split(' ').filter((val) => val !== '').map((num) => parseInt(num));

    days = values[0];
    hours = values[1];
    minutes = values[2];
    seconds = values[3];
  }

  const timerID = setInterval(function() {

    const noDaysHoursLeft = days === 0 && hours === 0 ? true: false;
    const noMinutesSecondsLeft = minutes === 0 ? true : false;


  if (noDaysHoursLeft && noMinutesSecondsLeft) {
    seconds = 0;
    minutes = 0;
  }
  else if (seconds === 0) {

    minutes = minutes - 1;
    seconds = 59;
  }
  else  {
       seconds = seconds - 1;
  }


  if (minutes === 0 && !noDaysHoursLeft) {
    minutes = 59;
    hours = hours - 1;
  }

  if (hours < 1 && days > 0) {
    hours = 23;
    days = days - 1;
  } else if (hours < 1 && days < 1) {
    hours = 0;
    days = 0;
  }

  if (noDaysHoursLeft && noMinutesSecondsLeft) {

    clearInterval(timerID);
    time.innerHTML = "Time is up!";

  } else {
    message =  `${days}d ${hours}hrs ${minutes}mins ${seconds}s`;
  time.innerHTML = `<i class="far fa-clock"></i> ${message} `;

  }
}, 1000);

}


const timers = [];

const getCurrentTimers = (timerArr, timers) => {

   timers.forEach((timer) => {

    timerArr.push({timer: timer.textContent, timerId: timer.dataset.id});

    });

 document.cookie = `timers=${JSON.stringify(timerArr)}`;
}


window.addEventListener('DOMContentLoaded', (e) => {

  document.cookie = "elapsedTime=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
if (document.cookie.indexOf('timers=') > 0) {
  getCurrentTimers(timers, times);

}
});

window.addEventListener('beforeunload', (e) => {

  const now = Math.round(Date.now() / 1000);

  document.cookie = `elapsedTime=${now}`;
    getCurrentTimers(timers, times);


});

times.forEach((time) => {

    initTimer(time);
});




function timeSince(timestamp_date) {
    let date = new Date(timestamp_date);
    let seconds = Math.floor((new Date() - date) / 1000);
    let interval = seconds / 31536000;
  
    if (interval > 1) {
      return Math.floor(interval) + " years ago";
    }
    interval = seconds / 2592000;
    if (interval > 1) {
      return Math.floor(interval) + " months ago";
    }
    interval = seconds / 86400;
    if (interval > 1) {
      return Math.floor(interval) + " days ago";
    }
    interval = seconds / 3600;
    if (interval > 1) {
      return Math.floor(interval) + " hours ago";
    }
    interval = seconds / 60;
    if (interval > 1) {
      return Math.floor(interval) + " minutes ago";
    }
    return Math.floor(seconds) + " seconds ago";
}

let getUrlParameter = function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

let formatJobNature = (job_nature) => {
    let job_natures = job_nature.split('-');
    let result = '';
    job_natures.forEach((job_nature) => {
        result += job_nature[0].toUpperCase() + job_nature.substring(1) + " ";
    });
    return result;
};

let isHttpValid = (link) => {
    try {
        const newUrl = new URL(link);
        return newUrl.protocol === 'http:' || newUrl.protocol === 'https:';
    } catch (err) {
        return false;
    }
}

let isValidPassowrd = (input) => {
    let password = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/;
    if(input.match(password)) {
        return true;
    }
    return false;
}
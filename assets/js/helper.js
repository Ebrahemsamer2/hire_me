
let timeSince = (timestamp) => {
    const date = new Date();
    const now_timestamp = date.getTime();
    const seconds = Math.floor(now_timestamp / 1000);
    
    const difference = seconds - timestamp;
    let output = ``;
    if (difference < 60) {
        // Less than a minute has passed:
        output = `${difference} seconds ago`;
    } else if (difference < 3600) {
        // Less than an hour has passed:
        output = `${Math.floor(difference / 60)} minutes ago`;
    } else if (difference < 86400) {
        // Less than a day has passed:
        output = `${Math.floor(difference / 3600)} hours ago`;
    } else if (difference < 2620800) {
        // Less than a month has passed:
        output = `${Math.floor(difference / 86400)} days ago`;
    } else if (difference < 31449600) {
        // Less than a year has passed:
        output = `${Math.floor(difference / 2620800)} months ago`;
    } else {
        // More than a year has passed:
        output = `${Math.floor(difference / 31449600)} years ago`;
    }
    return output;
  };

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

let formartJobNature = (job_nature) => {
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
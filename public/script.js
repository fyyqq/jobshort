console.log("%c" + "Jobshort", "color: #2891e1; font-size: 60px; font-weight: bold;");

$('.owl-carousel').owlCarousel({
    margin: 10,
    loop: false,
    autoWidth: true,
    items: 4,
    nav: false,
    dot: false
});

$(document).ready(function() {
    $(".fancybox").fancybox({
    buttons: [
        "zoom",
        "share",
        "slideShow",
        "fullScreen",
        "download",
        "thumbs",
        "close"
    ],
    loop: true,
    transitionEffect: "slide",
    transitionDuration: 500
    });

    $(".fancybox").fancybox();
    
    $(".fancybox-prev").click(function() {
        $.fancybox.prev();
    });
    
    $(".fancybox-next").click(function() {
        $.fancybox.next();
    });
});


  

function jobSearch() {
    const keyword = document.getElementById('searchbar').value;
    if (keyword.trim() != "") {
        return this.submit();
    } else {
        return false;
    }
}

const countryList = document.querySelectorAll('.suggestion-list');
const inputCountry = document.querySelectorAll('#location');

function displayCountries(names) {
    const li = document.createElement('li');
    li.textContent = names;
    countryList.forEach(element => {
        element.appendChild(li);
    });
}

function findCountries(countries, event) {
    const inputValue = event.target.value.toLowerCase();

    countryList.forEach(element => {
        element.innerHTML = '';
    });
    
    if (inputValue.trim() !== '') {
        const search = countries.filter(dt => {
            const countriesName = dt.name.common.toLowerCase();
            return countriesName.startsWith(inputValue);
        });

        if (search.length <= 5) {
            countryList.forEach(element => {
                element.style.height = 'max-content';
                element.style.overflowY = 'unset';
            });
        } else {
            countryList.forEach(element => {
                element.style.height = '200px';
                element.style.overflowY = 'scroll';
            });
        }
        
        search.forEach(dt => {
            const dataName = dt.name.common;
            
            displayCountries(dataName);
        });
        
        countryList.forEach(element => {
            element.style.display = 'block';
            chooseCountries(element, event);
        });
    } else {
        countryList.forEach(element => {
            element.style.display = 'none';
        });
    }
}

function allCountries(countries) {
    inputCountry.forEach(element => {
        element.addEventListener('keyup', event => {
            findCountries(countries, event);
        });
    });
}

function chooseCountries(element, input) {
    const li = element.querySelectorAll('li');
    li.forEach(data => {
        data.addEventListener('click', e => {
            const selectCountry = input.target.value = e.target.textContent;
            element.style.display = 'none';
            myStates(selectCountry);
        });
    });
}

const stateInput = document.querySelectorAll('#state');

function myStates(value) {
    if (value === "Malaysia") {
        fetch('/json/states.json').then(res => res.json())
        .then(data => {
            data.forEach(e => {
                stateInput.forEach(element => {
                    element.add(new Option(e.toLowerCase(), e));
                });
            });
        });
        stateInput.forEach(element => {
            myCity(element);
        });
    } else {
        stateInput.forEach(element => {
            element.innerHTML = "";
        });
    }
}

fetch('https://restcountries.com/v3.1/all')
.then(res => res.json())
.then(data => {
    allCountries(data);
});



const cityInput = document.querySelectorAll('#city');

function myCity(stateInput) {
    stateInput.addEventListener('change', e => {
        const stateValue = e.target.value;
    
        cityInput.forEach(element => {
            element.innerHTML = '';
        });
        
        fetch('/json/states-cities.json')
        .then(res => res.json())
        .then(data => {
            
            const cities = data[stateValue];

            cityInput.forEach(element => {
                element.add(new Option("Select Cities", null));
            });
            cities.forEach(e => {
                cityInput.forEach(element => {
                    element.add(new Option(e.toLowerCase(), e));
                });
            });
        });
    });
}


const fileImage = document.getElementById('profile-img');
const inputText = document.getElementById('file_text');
const img = document.getElementById('seller_img');

if (fileImage) {
    fileImage.addEventListener('change', () => {
        if (fileImage.files.length > 0) {
            const fileName =  fileImage.files[0];
            inputText.value =  fileImage.files[0].name;
            const imageUrl = URL.createObjectURL(fileName);
            img.removeAttribute('src');
            img.src = imageUrl;
        } else {
            inputText.value = 'Choose a file...';
        }
    });
}


if (inputText && inputText.nextElementSibling) {
    const deleteImgIcon = inputText.nextElementSibling;
    deleteImgIcon.addEventListener('click', e => {
        e.preventDefault();
    
        img.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU";
        inputText.value = 'Choose a file...';
        fileImage.value = '';
    });
}


const employer = document.querySelectorAll('input[name="employer_type"]');
const names = document.getElementById('name-title');
const number = document.getElementById('number-title');

employer.forEach(element => {
    element.addEventListener('change', e => {

        if (e.target.getAttribute('id') == 'company') {
            names.textContent = 'Company Name';
            number.textContent = 'Registered Business Number';
        } else {
            names.textContent = 'Name';
            number.textContent = 'Identification Number';
        }
    });
});


$(document).ready(function() {
    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Wishlist 
    $('.wishlist').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();

            const jobSlug = e.target.previousElementSibling.value;
            
            $(value).css('display', 'none');
            const unwishlist = $(value).siblings('.unwishlist');
            $(unwishlist).css('display', 'block');

            $(value).removeClass('d-block').addClass('d-none');
            unwishlist.removeClass('d-none').addClass('d-block');
            
            $.ajax({
                url: `/saved/${jobSlug}`,
                method: 'POST',
                success: function(response) {
                    iziToast.success({
                        title: 'Success',
                        message: 'Added to Wishlist',
                        position: 'bottomLeft'
                    });
                }
            });
        });
    });
    $('.unwishlist').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();

            const jobSlug = e.target.nextElementSibling.value;

            $(value).css('display', 'none');
            const wishlist = $(value).siblings('.wishlist');
            $(wishlist).css('display', 'block');

            wishlist.removeClass('d-none').addClass('d-block');
            $(value).removeClass('d-block').addClass('d-none');

            $.ajax({
                url: `/unsaved/${jobSlug}`,
                method: 'DELETE',
                success: function(response) {
                    iziToast.success({
                        title: 'Success',
                        message: 'Remove to Wishlist',
                        position: 'bottomLeft'
                    });
                }
            });
        });
    });

    // Order Services
    $('#order-btn').click(function(e) {
        e.preventDefault();

        var service_id = e.target.previousElementSibling.value; // 4
        var freelancer_id = e.target.nextElementSibling.value;

        $.ajax({
            url: `/orders/${service_id}/${freelancer_id}`,
            method: 'POST',
            success: function(res) {
                Swal.fire({
                    title: 'Successfully Order',
                    icon: 'success',
                    position: 'center',
                    cancelButtonText: 'back',
                    confirmButtonText: 'Check Order',
                    showCancelButton: true,
                    showCloseButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/account/profile/orders';
                    } else if (result.isDismissed) {
                        window.location.href = window.location.href;
                    }
                });
            }, error: function(error) {
                console.error(error.responseText);
            }
        });
    });

    // $('.jobCategories').each(function(index, value) {
    //     $(value).on('click', function(e) {
    //         e.preventDefault();
            
    //         var categoriesValue = $(value).find('small')[0].textContent;
            
    //         $.ajax({
    //             url: `/category/${categoriesValue}`,
    //             method: 'GET',
    //             success: function(res) {
    //                 $('#view-job').html(res);
    //                 history.pushState({}, '', $(value).data('url'));
    //             }
    //         });
    //     });
    // });

    $('.reject-btn').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();

            let orderId = ($(value).siblings('#order_id')).val();
            
            $.ajax({
                url: `/account/profile/orders/reject/${orderId}`,
                method: 'POST',
                success: function(res) {
                    console.log(res);
                }
            });
        });
    });

    $('.complete-btn').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();
            
            let orderId = ($(value).siblings('#order_id')).val();

            $.ajax({
                url: `/account/profile/orders/complete/${orderId}`,
                method: 'POST',
                success: function(res) {
                    console.log(res);
                }
            });
        });
    });

    $('.fa-star').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();

            $(this).prevAll().addBack().addClass('fa-solid');
            $(this).nextAll().addClass('fa-regular').removeClass('fa-solid');

            var indexStars = $(this).index() + 1;
            $('#starLength').val(indexStars);
        });
    });

    $('.formRating').submit(function(e) {
        e.preventDefault();

        if ($('#starLength').val() < 1) {
            alert('Star rating is required!');
            return;
        }

        var formData = new FormData(this);

        $.ajax({
            url: '/account/profile/orders/rating',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                window.location.href = res;
                // console.log(res);
            }, error: function(err) {
                console.error(err.responseText);
            }
        });
    });

    $('#notify').on('click', function(e) {
        e.preventDefault();

        $(this).addClass('d-none');

        var user_id = $(this).siblings('#user_id').val();
        var freelancer_id = $(this).siblings('#freelancer_id').val();
        
        $.ajax({
            url: `/notify/${user_id}/${freelancer_id}`,
            method: 'POST',
            success: function(res) {
                iziToast.success({
                    title: 'Success',
                    message: 'Notification Turn On',
                    position: 'bottomLeft'
                });
            }
        });
        $(this).next().removeClass('d-none');
    });

    $('#disnotify').on('click', function(e) {
        e.preventDefault();

        $(this).addClass('d-none');
        
        var user_id = $(this).siblings('#user_id').val();
        var freelancer_id = $(this).siblings('#freelancer_id').val();

        $.ajax({
            url: `/disnotify/${user_id}/${freelancer_id}`,
            method: 'DELETE',
            success: function(res) {
                iziToast.success({
                    title: 'Success',
                    message: 'Notification Turn Off',
                    position: 'bottomLeft'
                });
            }
        });
        $(this).prev().removeClass('d-none');
    });
});

function autoImage(event) {
    if (event.target.files.length > 0) {
        const fileName = event.target.files[0];

        const imgTag = event.target.previousElementSibling;
        const icon = event.target.nextElementSibling;

        const xmark = event.target.nextElementSibling.nextElementSibling;;
        xmark.classList.remove('d-none');
        xmark.addEventListener('click', e => {
            e.preventDefault();
            imgTag.removeAttribute('src');
            imgTag.classList.add('d-none');
            icon.classList.remove('d-none');
            e.target.classList.add('d-none');
        });

        const imageUrl = URL.createObjectURL(fileName);
        imgTag.src = imageUrl;
        imgTag.classList.remove('d-none');
        icon.classList.add('d-none');
    }
}

// fetch('https://restcountries.com/v3.1/all')
// .then(res => res.json())
// .then(data => {
//     const dt = data.filter(e => e.name.common === 'Malaysia');
//     dt.forEach(e => {
//         console.log(e.currencies.MYR.symbol);
//     });
// });




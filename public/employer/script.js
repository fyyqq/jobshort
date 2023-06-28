
const open_close_btn = document.getElementById('btn_open_close');
const sidebar = document.getElementsByClassName('sidebar')[0];
const sidebarLogo = document.getElementsByClassName('sidebar-logo')[0];
const sidebarLogoText = document.querySelector('.sidebar-logo img');
const sidebarProfile = document.querySelector('.profile');
const sidebarProfileText = document.querySelector('.profile .d-flex .mt-1');
const linkListParent = document.querySelectorAll('.link-list .navbar-nav .dropdown-item a');
const linkListText = document.querySelectorAll('.link-list .navbar-nav .dropdown-item a .col-8');
const linkListIcon = document.querySelectorAll('.link-list .navbar-nav .dropdown-item a.active span');
const contentEmployer = document.querySelector('.container-employer .content');

open_close_btn.addEventListener('click', e => {
    e.preventDefault();
    const sidebarCloseSize = 85; 
    const sidebarOpenSize = 235; 

    if (sidebar.style.width != `${sidebarCloseSize}px`) {
        sidebarLogoText.style.display = 'none';
        sidebarLogo.style.columnGap = '0px';
        sidebarLogo.style.transform = 'translateX(0px)';
        sidebar.style.width = `${sidebarCloseSize}px`;
        sidebar.style.transition = 'width .3s ease';
        sidebarProfile.classList.remove('justify-content-start');
        sidebarProfile.classList.add('justify-content-center');
        sidebarProfileText.classList.add('d-none');
        linkListParent.forEach(e => {
            e.classList.add('justify-content-center');
        });
        linkListText.forEach(e => {
            e.classList.add('d-none');
        });
        linkListIcon.forEach(e => {
            e.style.transform = 'translateX(13px)';
        });
        contentEmployer.style.width = `calc(100% - ${sidebarCloseSize}px)`;
    } else {
        sidebarLogoText.style.display = 'flex';
        sidebarLogoText.style.transition = 'display .3s ease';
        sidebarLogo.style.columnGap = '8px';
        sidebarLogo.style.transform = 'translateX(-10px)';
        sidebar.style.width = `${sidebarOpenSize}px`;
        sidebar.style.transition = 'width .3s ease';
        sidebarProfile.classList.remove('justify-content-center');
        sidebarProfile.classList.add('justify-content-start');
        sidebarProfileText.classList.remove('d-none');
        linkListParent.forEach(e => {
            e.classList.remove('justify-content-center');
        });
        linkListText.forEach(e => {
            e.classList.remove('d-none');
        });
        contentEmployer.style.width = `calc(100% - ${sidebarOpenSize}px)`;
    }
});

const inputText = document.getElementById('file_text');
const img = document.getElementById('seller_img');

function freelancerImage(event) {
    if (event.files.length > 0) {
        const fileName = event.files[0];
        inputText.value = event.files[0].name;
        const imageUrl = URL.createObjectURL(fileName);
        img.removeAttribute('src');
        img.src = imageUrl;
    } else {
        inputText.value = 'Choose a file...';
    }
}

if (inputText && inputText.nextElementSibling) {
    const fileImage = document.getElementById('employer-img');
    const deleteImgIcon = inputText.nextElementSibling;
    deleteImgIcon.addEventListener('click', e => {
        e.preventDefault();
    
        img.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU";
        inputText.value = 'Choose a file...';
        fileImage.value = '';
    });
}


const checkJobs = document.querySelectorAll('#select-jobs');

function allJobs() {
    const checkAllJobs = document.getElementById('select-all-jobs');
    if (checkAllJobs.checked) {
        checkJobs.forEach(element => {
            element.checked = true;
        });
    } else {
        checkJobs.forEach(element => {
            element.checked = false;
        });
    }
}

function deleteSelectedItems() {
    var selectedItems = [];
    checkJobs.forEach(element => {
        if (element.checked) {
            selectedItems.push(element.nextElementSibling.value);
        }
    });

    
}

$(document).ready(function() {
    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    
    // var buttonProfile = $('.profile-employer-btn');
    // buttonProfile.each(function(index, value) {
    //     $(value).on('click', function(e) {
    //         e.preventDefault();

    //         var link = this.getAttribute('href');

    //         $.ajax({
    //             url: link,
    //             method: 'GET',
    //             success: function(response) {
    //                 $('.form-profile').html(response);
    //                 history.pushState({}, '', link);
    //             }, error: function(error) {
    //                 console.error(error);
    //             }
    //         });
    //     });
    // });

    $('.approve-btn').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();

            let orderId = ($(value).siblings('#order_id'))[0].value;

            $.ajax({
                url: `/account/freelancer/orders/approve/${orderId}`,
                method: 'POST',
                success: function(res) {
                    console.log(res);
                }
            });
        });
    });

    $('.reject-btn').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();
            
            let orderId = ($(value).siblings('#order_id'))[0].value;
            
            $.ajax({
                url: `/account/freelancer/orders/reject/${orderId}`,
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
            
            let orderId = ($(value).siblings('#order_id'))[0].value;

            $.ajax({
                url: `/account/freelancer/orders/complete/${orderId}`,
                method: 'POST',
                success: function(res) {
                    console.log(res);
                }
            });
        });
    });

    // Add Image on Create Service

    $('#addImage').click(function(e) {
        e.preventDefault();

        const imageContainer = $('.addImageContainer')[0];

        const parent = document.createElement('div');
        parent.className = 'me-2 border border-dark rounded position-relative d-flex align-items-center justify-content-center serviceImages';
        $(parent).css({ "height": "95px", "width": "95px", "overflow": "hidden" });

        const inputFile = document.createElement('input');
        inputFile.type = 'file';
        inputFile.name = 'images[]';
        inputFile.id = 'profile-img';
        inputFile.accept = '.png, .jpg, .jpeg';
        inputFile.onchange = function(event) {
            if (event.target.files.length > 0) {
                const fileName = event.target.files[0];
                const imageUrl = URL.createObjectURL(fileName);
    
                const imgTag = event.target.previousElementSibling;
                const icon = event.target.nextElementSibling;
                const icon2 = event.target.nextElementSibling.nextElementSibling;
                const icon3 = event.target.nextElementSibling.nextElementSibling.nextElementSibling;
                
                icon3.classList.add('d-none');
                imgTag.classList.remove('d-none');
                imgTag.src = imageUrl;
                icon.classList.add('d-none');
                icon2.classList.remove('d-none');

                icon2.addEventListener('click', e => {
                    e.preventDefault();

                    imgTag.classList.add('d-none');
                    imgTag.removeAttribute('src');
                    icon.classList.remove('d-none');
                    icon2.classList.add('d-none');
                    icon3.classList.remove('d-none');
                });
            }
        }

        const img = document.createElement('img');
        img.className = 'w-100 h-100 d-none';
        img.style.objectFit = 'cover';

        const icon = document.createElement('i');
        icon.className = 'fa-solid fa-image';
        $(icon).css('font-size', '18px');

        const icon2 = document.createElement('i');
        icon2.className = 'fa-solid fa-xmark p-1 position-absolute d-none';
        $(icon2).css({ 'font-size': '13px', 'top': '0', 'right': '0' });

        const icon3 = document.createElement('i');
        icon3.className = 'fa-solid fa-xmark p-1 position-absolute';
        $(icon3).css({ 'font-size': '13px', 'top': '0', 'right': '0' });

        imageContainer.appendChild(parent);
        parent.appendChild(img);
        parent.appendChild(inputFile);
        parent.appendChild(icon);
        parent.appendChild(icon2);
        parent.appendChild(icon3);
        
        $(icon3).click(function(e) {
            e.preventDefault();

            const parent = $(this).parent();
            $(parent).remove();

            const imgLength = $('.serviceImages').length;
            $('#lengthImg')[0].innerText = '';
            $('#lengthImg')[0].innerText = imgLength + 1;

            if (imgLength <= 5) {
                $('#addImage').removeClass('d-none');
            }
        });

        const imgLength = $('.serviceImages').length;
        $('#lengthImg')[0].innerText = '';
        $('#lengthImg')[0].innerText = imgLength + 1;

        if (imgLength >= 5) {
            $(this).addClass('d-none');
        }
    });
});



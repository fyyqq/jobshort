const open_close_btn = document.getElementById('btn_open_close');
const sidebar = document.getElementsByClassName('sidebar')[0];
const sidebarLogo = document.getElementsByClassName('sidebar-logo')[0];
const sidebarLogoText = document.querySelector('.sidebar-logo img');
const sidebarProfile = document.querySelector('.profile');
const sidebarProfileText = document.querySelector('.profile .d-flex .mt-1');
const linkListParent = document.querySelectorAll('.link-list .navbar-nav .dropdown-item a');
const lastChild = document.querySelectorAll('.link-list .navbar-nav .dropdown-item a')[6];
const linkListText = document.querySelectorAll('.link-list .navbar-nav .dropdown-item a .col-8');
const linkListIcon = document.querySelectorAll('.link-list .navbar-nav .dropdown-item a.active span');
const contentFreelancer = document.querySelector('.container-freelancer .content');

const loader = document.querySelector('.custom-loader');

// Sidebar Opan & Close
open_close_btn.addEventListener('click', e => {
    e.preventDefault();
    const sidebarCloseSize = 85;
    const sidebarOpenSize = 235; 

    contentFreelancer.classList.add('active');
    
    if (sidebar.style.width != `${sidebarCloseSize}px`) {
        open_close_btn.style.right = '-13px';
        open_close_btn.style.transform = 'translateY(-50%) rotate(0deg)';
        lastChild.childNodes[1].style.paddingRight = "20px";
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
        contentFreelancer.classList.add('active');
    } else {
        open_close_btn.style.right = '-23px';
        open_close_btn.style.transform = 'translateY(-50%) rotate(180deg)';
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
        contentFreelancer.classList.remove('active');
    }
});

const inputText = document.getElementById('file_text');
const img = document.getElementById('seller_img');

// Profile Page

// Insert Freelancer Image
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

// Insert Unknown Image if delete
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

$(document).ready(function() {
    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Notification Page

    // Read Notification
    $(document).on('click', '.read', function(e) {
        e.preventDefault();

        var id = $(this).siblings('#notification-id').val();
        $(this).removeClass('d-block');
        $(this).addClass('d-none');
        $(this).prev().removeClass('d-none');
        $(this).prev().addClass('d-block');
        const container = $(this).parents()[1];
        
        $.ajax({
            url: `/notifications/read/${id}`,
            method: 'POST',
            success: function(res) {
                if (res) {
                    $(container).css('border', 'unset');
                    iziToast.success({
                        title: 'Success',
                        message: 'Mark As Read',
                        position: 'bottomLeft'
                    });
                }
            }, error: function(err) {
                console.log(err.responseText);
            }
        });
    });

    // Unread Notification
    $(document).on('click', '.unread', function(e) {
        e.preventDefault();

        var id = $(this).siblings('#notification-id').val();
        $(this).removeClass('d-block');
        $(this).addClass('d-none');
        $(this).next().removeClass('d-none');
        $(this).next().addClass('d-block');
        const container = $(this).parents()[1];

        $.ajax({
            url: `/notifications/unread/${id}`,
            method: 'POST',
            success: function(res) {
                if (res) {
                    $(container).css('border-left', '3px solid #2891e1');
                    iziToast.success({
                        title: 'Success',
                        message: 'Mark As Unread',
                        position: 'bottomLeft'
                    });
                }
            }, error: function(err) {
                console.log(err.responseText);
            }
        });
    });

    // Delete Notification
    $(document).on('click', '.notification-delete', function(e) {
        e.preventDefault();

        var id = $(this).siblings('#notification-id').val();
        const parent = $(this).closest('.parent-notification');

        $.ajax({
            url: `/notifications/delete/${id}`,
            method: 'DELETE',
            success: function(res) {
                if (res) {
                    iziToast.success({
                        title: 'Success',
                        message: 'Deleted',
                        position: 'bottomLeft'
                    });
                    $(parent).remove();
                }
            }, error: function(err) {
                console.log(err.responseText);
            }
        });
    });

    // Page Notification
    const notifications = document.querySelectorAll('#notification-link');

    $(document).on('click', '#notification-link', function(e) {
        e.preventDefault();

        $(loader).show();

        $(notifications).removeClass('border-bottom border-2 border-primary');
        $(this).addClass('border-bottom border-2 border-primary');

        const path = $(this).data('notification-path');
        const type = $(this).data('type');

        const parent = $('#container_notification');

        $.ajax({
            url: path,
            method: 'get',
            success: function(res) {
                history.pushState(null, null, path);
                setTimeout(() => {
                    $(loader).hide();
                    $(parent).html('');
                    $(parent).html(res);

                    const centerClass = 'd-flex align-items-center justify-content-center';

                    if (res === '') {
                        $(parent).css('height', '400px').addClass(centerClass);
                        const div = document.createElement('div');
                        $(div).addClass('d-flex align-items-center justify-content-center flex-column-reverse gap-3');
                        const p = document.createElement('p');
                        p.className = 'mb-0 text-muted';
                        p.innerHTML = `Empty ${type} Notifications`;
                        const icon = document.createElement('i');
                        icon.className = 'fa-regular fa-folder-open';
                        icon.style.fontSize = '35px';
                        div.append(p, icon);
                        $(parent).html(div);
                    } else {
                        $(parent).css('height', 'max-content').removeClass(centerClass);
                    }
                }, 1000);
            }, error: function(err) {
                console.log(err);
            }
        });
    });

    // Services Page

    // change service page [active, archive]
    $(document).on('click', '.service-link', function(e) {
        e.preventDefault();

        $(loader).show();
        $('.service-link').removeClass('active');
        $(this).addClass('active');
        
        const url = $(this).data('service-link');
        const container = $(parent);

        const type = $(this).text();

        const archiveBtn = $('#archive_btn');
        const activeBtn = $('#active_btn');

        const buttonParent = $(activeBtn).parent();
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                history.pushState(null, null, url);
                setTimeout(() => {
                    $(container).html('');
                    $(loader).hide();
                    $(container).html(res);

                    document.getElementById('select-all-services').checked = false;
                    
                    if (type === 'Active') {
                        $(archiveBtn).removeClass('d-none');
                        $(activeBtn).addClass('d-none')
                    } else if (type === 'Archive') {
                        $(activeBtn).removeClass('d-none');
                        $(archiveBtn).addClass('d-none');
                    }
                    
                    if (res === '') {
                        $(container).css('height', '400px');
                        $(buttonParent).removeClass('d-flex');
                        $(buttonParent).addClass('d-none');
                        const div = document.createElement('div');
                        div.className = 'd-flex align-items-center justify-content-center flex-column gap-3';
                        const p = document.createElement('p');
                        p.innerHTML = 'No Services Yet';
                        p.className = 'text-muted mb-0';
                        const icon = document.createElement('i');
                        icon.className = 'fa-regular fa-folder-open';
                        icon.style.fontSize = '35px';
                        $(div).append(icon, p);
                        $(parent).html(div);
                    } else {
                        $(container).css('height', 'max-content');
                        $(buttonParent).removeClass('d-none');
                        $(buttonParent).addClass('d-flex');
                    }
                }, 1000);
            }
        });
    });

    // Active Service
    $(document).on('click', '.active-service-btn', function(e) {
        e.preventDefault();

        const slug = $(this).siblings('#service-slug').val(); 

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-sm px-3 py-2 btn-primary',
            },
            buttonsStyling: false
        })

        const parent = $(this).parents().closest('#parent_service');

        swalWithBootstrapButtons.fire({
            title: 'Active ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            position: 'center',
            confirmButtonText: 'Confirm',
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                axios.put(`/account/freelancer/services/active/${slug}`).then(function(res) {
                    if (res.data) {
                        $(parent).remove();
                        swalWithBootstrapButtons.fire(
                            'Active!',
                            'Your Services Has Been Active.',
                            'success'
                        );
                    }
                });
            }
        });
    });

    // Archive Service
    $(document).on('click', '.archive-service-btn', function(e) {
        e.preventDefault();

        const slug = $(this).siblings('#service-slug').val(); 

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-sm px-3 py-2 btn-primary',
            },
            buttonsStyling: false
        })

        const parent = $(this).parents().closest('#parent_service');

        swalWithBootstrapButtons.fire({
            title: 'Archive ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            position: 'center',
            confirmButtonText: 'Confirm',
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                axios.put(`/account/freelancer/services/archive/${slug}`).then(function(res) {
                    if (res.data) {
                        $(parent).remove();
                        swalWithBootstrapButtons.fire(
                            'Archived!',
                            'Your Services Has Been Archived.',
                            'success'
                        );
                    }
                });
            }
        });
    });
    
    // Delete Service
    $(document).on('click', '.delete-service-btn', function(e) {
        e.preventDefault();
        
        const slug = $(this).siblings('#service-slug').val(); 

        const parent = $(this).parents().closest('#parent_service');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-sm px-3 py-2 btn-primary',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Deleted ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            position: 'center',
            confirmButtonText: 'Confirm',
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(`/account/freelancer/services/delete/${slug}`).then(function(res) {
                    if (res.data) {
                        $(parent).remove();
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your Services Has Been Deleted.',
                            'success'
                        );
                    }
                });
            }
        });
    });

    // Select All Services Option
    $('#select-all-services').click(function(e) {
        const checkAllService = document.getElementById('select-all-services');
        const checkServices = document.querySelectorAll('#select-services');

        if (checkAllService.checked) {
            checkServices.forEach(element => {
                element.checked = true;
            });
        } else {
            checkServices.forEach(element => {
                element.checked = false;
            });
        }
    });  

    // Order Page
    
    // change order page [pending, approved, rejected, completed]
    $(document).on('click', '.order-menu-link', function(e) {
        e.preventDefault();

        $(loader).show();
        let url = $(this).data('order-link');
        let type = $(this).data('type');
        const container = $('#display-order');

        $('.order-menu-link').removeClass('border-bottom border-2 border-primary');
        $(this).addClass('border-bottom border-2 border-primary');
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                history.pushState(null, null, url);
                setTimeout(() => {
                    $(container).html('');
                    $(loader).hide();
                    $(container).html(res);
                    if (res === '') {
                        $(container).css('height', '400px');
                        const div = document.createElement('div');
                        div.className = 'd-flex align-items-center justify-content-center flex-column gap-3';
                        const icon = document.createElement('i');
                        icon.className = 'fa-regular fa-folder-open d-block';
                        icon.style.fontSize = '35px';
                        const p = document.createElement('p');
                        p.className = 'text-muted mb-0';
                        p.innerHTML = `No ${type} Order`;
                        $(div).append(icon, p);
                        $(container).html(div);
                    } else {
                        $(container).css('height', 'max-content');
                    }
                }, 1000);
            }
        });
    });

    // Approve Order Btn 
    $('.approve-btn').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();
            $(loader).show();
            
            let orderId = ($(value).siblings('#order_id'))[0].value;
            const container = $(this).closest('#order_container');
            
            $.ajax({
                url: `/account/freelancer/orders/approve/${orderId}`,
                method: 'POST',
                success: function(res) {
                    setTimeout(() => {
                        $(loader).hide();
                        $(container).remove();
                    }, 1000);
                }
            });
        });
    });
    
    // Create & Update

    // Information Price
    $(".info_price").on( "click", function() {
        const info = $('.info_price_text');
        if (!$(this).hasClass('active')) {
            $(this).addClass('active')
            $(info).show();
        } else {
            $(this).removeClass('active');
            $(info).hide();   
        }
    });

    // Filter Price
    $("input[name='price']").on('keyup', function() {
        const values = $(this).val();
        const info = $('.info_price');
        const loader = $('#price_loader');
        const text = $(this).parent().siblings('#fees');
        const priceAfterFee = $(this).parent().siblings('#fees').children('div').children('#price_fee');
        priceAfterFee.text('');
        if (values.trim()) {
            let price = parseInt(values);
            let totalPrice = price + (price * 0.10);
            totalPrice = totalPrice.toFixed(2);
            
            $(info).hide();
            $(loader).show();
            setTimeout(() => {
                $(info).show();
                $(loader).hide();
                priceAfterFee.text(`$ ${totalPrice}`);
                $(text).removeClass('d-none');
                $(text).addClass('d-flex');
                $(text).children('input').val(totalPrice);
            }, 1000);
        } else {
            $(this).val('');
            setTimeout(() => {
                $(text).addClass('d-none');
                $(text).children('input').val('');
            }, 1000);
        }
    });

    // Filter Delivery
    const delivery = document.querySelectorAll('#delivery_input');
    $(delivery).each(function(index, element) {
        $(element).on('keyup', function() {
            const values = $(this).val().trim();
            const attr = $(this).attr('name');
            const duration_text = $(this).parents().eq(1).siblings('#delivery');
            const text = $(duration_text).children('div').children('#delivery_duration');

            let min_delivery = $('[name="min_delivery"]').val().trim();
            let max_delivery = $('[name="max_delivery"]').val().trim();
            if (values !== '') {
                if (attr === 'min_delivery') {
                    min_delivery = values;
                } else if (attr === 'max_delivery') {
                    max_delivery = values;
                }
                $(duration_text).removeClass('d-none');
                $(duration_text).addClass('d-flex');
                $(text).text(`${min_delivery} - ${max_delivery}`);
            } else {
                $(this).val('');
            }
        });
    });

    // Filter Title Add Create
    $('#title').on('input', function(e) {
        var value = e.target.value;
        
        if (value.length > 100) {
            cutString = value.substring(0, 100);
            e.target.value = cutString;

            e.target.nextElementSibling.style.color = 'red';
        } else {
            e.target.nextElementSibling.style.color = '';
        }
    });

    // Add Image Container
    $('#addImage').click(function(e) {
        e.preventDefault();

        const imageContainer = $('.addImageContainer')[0];

        const parent = document.createElement('div');
        parent.className = 'me-2 border border-secondary rounded position-relative d-flex align-items-center justify-content-center serviceImages';
        parent.id = 'serviceImage';

        // Add Images Detail
        const inputFile = document.createElement('input');
        inputFile.type = 'file';
        inputFile.name = 'images[]';
        inputFile.id = 'profile-img';
        inputFile.accept = '.png, .jpg, .jpeg';
        inputFile.onchange = function(event) {
            if (event.target.files.length > 0) {
                const fileName = event.target.files[0];
                const imageUrl = URL.createObjectURL(fileName);
    
                const imgElement = event.target.previousElementSibling;
                // sync icon
                const icon0 = event.target.parentElement.childNodes[2];
                // image icon
                const icon = event.target.parentElement.childNodes[3];
                // remove image icon
                const icon2 = event.target.parentElement.childNodes[4];
                // remove image container icon
                const icon3 = event.target.parentElement.childNodes[5];

                imgElement.classList.remove('d-none');
                imgElement.src = imageUrl;
                icon0.classList.remove('d-none');
                icon.classList.add('d-none');
                icon2.classList.remove('d-none');
                icon3.classList.add('d-none');

                // Remove Image
                icon2.addEventListener('click', e => {
                    e.preventDefault();

                    imgElement.classList.add('d-none');
                    imgElement.removeAttribute('src');
                    icon0.classList.add('d-none');
                    icon.classList.remove('d-none');
                    icon2.classList.add('d-none');
                    icon3.classList.remove('d-none');
                    inputFile.value = "";
                });
            }
        }


        const img = document.createElement('img');
        img.className = 'w-100 h-100 d-none';
        img.style.objectFit = 'cover';

        const icon0 = document.createElement('i');
        icon0.className = 'mdi mdi-sync d-none text-light position-absolute';
        $(icon0).css({
            'font-size': '25px',
            'top': '50%',
            'left': '50%',
            'transform': 'translate(-50%, -50%)'
        });

        const icon = document.createElement('i');
        icon.className = 'mdi mdi-image';
        $(icon).css('font-size', '25px');

        const icon2 = document.createElement('span');
        icon2.className = 'text-light position-absolute p-1 d-none';
        icon2.id = 'delete_image';
        $(icon2).css({ 'top': '0', 'right': '0' });
        
        const icons = document.createElement('span');
        icons.className = 'fa-solid fa-xmark';
        $(icons).css({ 'font-size' : '11px' });
        $(icon2).append(icons);

        const icon3 = document.createElement('i');
        icon3.className = 'fa-solid fa-xmark p-1 position-absolute';
        $(icon3).css({ 'font-size': '13px', 'top': '0', 'right': '0' });

        imageContainer.appendChild(parent);
        parent.appendChild(img);
        parent.appendChild(inputFile);
        parent.appendChild(icon0);
        parent.appendChild(icon);
        parent.appendChild(icon2);
        parent.appendChild(icon3);
        
        const countElement = ('#lengthImg');
        const addImgLength = $('.serviceImages').length;
        
        // Remove container add images
        $(icon3).click(function(e) {
            e.preventDefault();

            const parent = $(this).parent();
            $(parent).remove();

            $(countElement).html('');
            $(countElement).html(addImgLength + 1);

            if (addImgLength <= 14) {
                $('#addImage').show();
            }

            updateScroll();
        });

        // add image length
        
        const countEditElement = $('#lengthEditImg');
        const countEditElement2 = $('#lengthEditImg2');
        
        var calcEditAdd = parseInt($(countEditElement).text()) + addImgLength;
        $(countEditElement).hide();
        $(countEditElement2).removeClass('d-none');
        $(countEditElement2).text(calcEditAdd);

        // Create Image
        
        const calcAdd = addImgLength + 1;
        $(countElement).html(calcAdd);

        if (addImgLength >= 14 || calcEditAdd >= 15) {
            $(this).hide();
        }

        updateScroll();
    });
});

// Insert Image
function insertImage(event) {
    if (event.files.length > 0) {
        const fileName = event.files[0];
        const destoryContainerIcon = $(event).siblings('.destoryImgContainer');
        $(destoryContainerIcon).addClass('d-none');

        const imgElement = $(event).siblings('img')[0];
        const imageIcon = $(event).prev();
        $(imageIcon).addClass('d-none');

        $(event).siblings('input:hidden').remove();

        const deleteImage = event.nextElementSibling;
        deleteImage.classList.remove('d-none');

        const syncIcon = $(event).siblings('.mdi-sync');
        $(syncIcon).removeClass('d-none');
        
        deleteImage.addEventListener('click', e => {
            e.preventDefault();
            $(imgElement).removeAttr('src');
            $(imgElement).addClass('d-none');
            e.target.classList.add('d-none');
            $(imageIcon).removeClass('d-none');
            $(syncIcon).addClass('d-none');
            event.value = '';
        });


        const imageUrl = URL.createObjectURL(fileName);
        imgElement.src = imageUrl;
        $(imgElement).removeClass('d-none');
    }
}

// Destroy Image
function destroyImage(event) {
    const destroyImgContainerIcon = $(event).next();
    const imgElement = $(event).siblings('img')[0];
    const imgIcon = $(event).siblings('.mdi-image');
    imgElement.src = '';
    $(imgElement).addClass('d-none');
    $(imgIcon).removeClass('d-none');
    $(destroyImgContainerIcon).removeClass('d-none');
    $(event).siblings("#data_img").remove();
    $(event).remove();
}

// Destroy Image Container
function destroyImageContainer(event) {
    $(event).parent().remove();
}

// Scroll Create Images 
function updateScroll() {
    const parentElement = document.getElementById('add-image-container');
    const childElement = document.getElementById('child-container');
    
    const parentWidth = parentElement.offsetWidth;
    const childWidth = childElement.offsetWidth;

    if (childWidth > parentWidth) {
        parentElement.style.overflowX = 'scroll';
    } else if (childWidth < parentWidth) {
        parentElement.style.overflowX = 'hidden';
    }
}

// Services Page

const parent = ('#parent-show-services');

// Filter Search
function searchServices(event) {
    
    const keyword = event.value;
    if (keyword.trim() != '') {
        $(loader).show();
    }

    axios.get('/account/freelancer/services/search', { params: { keyword } })
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).hide();
            $(parent).html('');
            $(parent).html(data);
        }, 2000);
    });
}

// Filter SortBy Desc Service
function sortByOldest(event) {
    $(loader).show();
    axios.get('/account/freelancer/services/sort-by-oldest')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).hide();
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    });
}

// Filter SortBy Desc Service
function sortByTopOrder(event) {
    $(loader).show();
    axios.get('/account/freelancer/services/sort-by-top-order')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).hide();
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    });
}

// Filter SortBy Desc Rating
function sortByTopRating(event) {
    $(loader).show();
    axios.get('/account/freelancer/services/sort-by-top-rating')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).hide();
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    }).catch(err => console.error(err.message));
}

// Filter Price Desc
function priceRangeTop(event) {
    $(loader).show();

    event.removeAttribute('onclick');
    event.setAttribute('onclick', 'return priceRangeDown(this)');

    const filter_icon = event.childNodes[3].childNodes[1];
    filter_icon.classList.remove('mdi-unfold-more-horizontal');
    filter_icon.classList.add('mdi-menu-down');
    
    axios.get('/account/freelancer/services/sort-by-high-price')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).hide();
            $(parent).html('');
            $(parent).html(data);
        }, 1300);

    }).catch(function(error) {
        console.error(error.message);
    });
}

// Filter Price Asc
function priceRangeDown(event) {
    $(loader).show();

    event.removeAttribute('onclick');
    event.setAttribute('onclick', 'return priceRange(this)');

    const filter_icon = event.childNodes[3].childNodes[1];
    filter_icon.classList.remove('mdi-unfold-more-horizontal');
    filter_icon.classList.add('mdi-menu-up');
    
    axios.get('/account/freelancer/services/sort-by-low-price')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).hide();
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    }).catch(function(error) {
        console.error(error.message);
    });
}

// Filter Price Normal
function priceRange(event) {
    $(loader).show();
    
    event.removeAttribute('onclick');
    event.setAttribute('onclick', 'return priceRangeTop(this)');
    
    const filter_icon = event.childNodes[3].childNodes[1];
    filter_icon.classList.remove('mdi-menu-up');
    filter_icon.classList.add('mdi-unfold-more-horizontal');
    
    axios.get('/account/freelancer/services/sort-by-normal-price')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).hide();
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    }).catch(function(error) {
        console.error(error.message);
    });
}

// Delete Selected Services
function deleteSelectedItems() {
    const checkServices = document.querySelectorAll('#select-services');
    var selectedItems = [];
    var selectedElement = [];
    checkServices.forEach(element => {
        if (element.checked) {
            selectedItems.push(element.nextElementSibling.value);
            selectedElement.push(element);
        }
    });

    if (selectedItems.length == 0) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'd-none',
                closeButton: 'shadow-none',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Delete',
            text: 'Select Items First Before Delete',
            icon: 'warning',
            position: 'center',
            showCloseButton: true,
        });
    } else {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-sm px-3 py-2 btn-primary',
              closeButton: 'shadow-none',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Delete ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            position: 'center',
            confirmButtonText: 'Confirm',
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(`/account/freelancer/services/delete-items`, { selectedItems })
                .then(function(res) {
                    if (res.data) {
                        $(selectedElement).each(function(index, value) {
                            $(value).closest('#parent_service').remove();
                        });
                        swalWithBootstrapButtons.fire(
                            'Deleted!',
                            'Your Selected Items has been Deleted.',
                            'success'
                        );
                    }
                });
            }
        });
    }    
}

// Active Selected Services
function activeSelectedItems() {
    const checkServices = document.querySelectorAll('#select-services');

    var selectedItems = [];
    var selectedElement = [];
    checkServices.forEach(element => {
        if (element.checked) {
            selectedItems.push(element.nextElementSibling.value);
            selectedElement.push(element);
        }
    });

    if (selectedItems.length == 0) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'd-none',
                closeButton: 'shadow-none',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Active',
            text: 'Select Items First Before Active',
            icon: 'warning',
            position: 'center',
            showCloseButton: true,
        });
    } else {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-sm px-3 py-2 btn-primary',
              closeButton: 'shadow-none',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Active ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            position: 'center',
            confirmButtonText: 'Confirm',
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(`/account/freelancer/services/active-items`, { selectedItems })
                .then(function(res) {
                    $(selectedElement).each(function(index, value) {
                        $(value).closest('#parent_service').remove();
                    });
                    if (res.data) {
                        swalWithBootstrapButtons.fire(
                            'Active!',
                            'Your Selected Items has been Active.',
                            'success'
                        );
                    }
                });
            }
        });
    }
}

// Archive Selected Services
function archiveSelectedItems() {
    const checkServices = document.querySelectorAll('#select-services');

    var selectedItems = [];
    var selectedElement = [];
    checkServices.forEach(element => {
        if (element.checked) {
            selectedItems.push(element.nextElementSibling.value);
            selectedElement.push(element);
        }
    });

    if (selectedItems.length == 0) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'd-none',
                closeButton: 'shadow-none',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Archive',
            text: 'Select Items First Before Archive',
            icon: 'warning',
            position: 'center',
            showCloseButton: true,
        });
    } else {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-sm px-3 py-2 btn-primary',
              closeButton: 'shadow-none',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Archive ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            position: 'center',
            confirmButtonText: 'Confirm',
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(`/account/freelancer/services/archive-items`, { selectedItems })
                .then(function(res) {
                    $(selectedElement).each(function(index, value) {
                        $(value).closest('#parent_service').remove();
                    });
                    if (res.data) {
                        swalWithBootstrapButtons.fire(
                            'Archived!',
                            'Your Selected Items has been Archived.',
                            'success'
                        );
                    }
                });
            }
        });
    }    
}

// Back History Button
function goToPreviousPage() {
    window.history.back();
}

// Countries Api
fetch('https://restcountries.com/v3.1/all')
.then(res => res.json())
.then(data => {
    getCountries(data);
});

const listContainer = document.querySelectorAll('.suggestion-list');

function getCountries(countries) {
    $('#countryInput').on('keyup', function(e) {
        var value = $(this).val();

        listContainer.forEach(element => {
            element.innerHTML = '';
        });

        $(listContainer).show();
        
        if (value.trim() != '') {
            const search = countries.filter(dt => {
                const countriesName = dt.name.common.toLowerCase();
                return countriesName.startsWith(value);
            });
            
            $(search).each(function(index, value) {
                var names = value.name.common;
                
                displayCountries(names);
            });

            if (search.length <= 5) {
                listContainer.forEach(element => {
                    element.style.height = 'max-content';
                    element.style.overflowY = 'unset';
                });
            } else {
                listContainer.forEach(element => {
                    element.style.height = '200px';
                    element.style.overflowY = 'scroll';
                });
            }
            selectCountry($(this));
        } else {
            $(listContainer).hide();
        }
    });
}

function displayCountries(data) {
    const newElement = document.createElement('li')
    newElement.innerHTML = data;
    newElement.className = 'py-2 px-3 text-muted border';
    
    listContainer.forEach(element => {
        element.appendChild(newElement);
    });
}

function selectCountry(element) {
    const countryLists = $(listContainer).children();
    $(countryLists).on('click', function(e) {
        e.preventDefault();

        $(element).removeAttr('value');
        $(element).attr('value', $(this).text());
        $(element).val($(this).text());

        $(listContainer).hide();
    });
}





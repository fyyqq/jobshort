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
const contentEmployer = document.querySelector('.container-employer .content');

const loader = document.querySelector('.custom-loader');

// Sidebar Opan & Close
open_close_btn.addEventListener('click', e => {
    e.preventDefault();
    const sidebarCloseSize = 85; 
    const sidebarOpenSize = 235; 

    
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
        contentEmployer.style.width = `calc(100% - ${sidebarCloseSize}px)`;
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
        contentEmployer.style.width = `calc(100% - ${sidebarOpenSize}px)`;
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

        $.ajax({
            url: `/notifications/delete/${id}`,
            method: 'DELETE',
            success: function(res) {
                $(this).parent().parent().remove();
                if (res) {
                    iziToast.success({
                        title: 'Success',
                        message: 'Deleted',
                        position: 'bottomLeft'
                    });
                }
            }, error: function(err) {
                console.log(err.responseText);
            }
        });
    });

    // Inbox Page Notification
    $(document).on('click', '.inbox-notification', function(e) {
        e.preventDefault();

        $(loader).css('display', 'block');
        
        const parent = $('#container_notification');
        axios.get('/account/freelancer/notifications/inbox')
        .then(res => {
            setTimeout(() => {
                $(loader).css('display', 'none'); 
                $(parent).html('');;
                $(parent).html(res.data);
            }, 1000);
        }).catch(err => console.log(err));
    });
    
    // Order Page Notification
    $(document).on('click', '.order-notification', function(e) {
        e.preventDefault();

        $(loader).css('display', 'block');
        
        const parent = $('#container_notification');
        axios.get('/account/freelancer/notifications/orders')
        .then(res => {
            setTimeout(() => {
                $(loader).css('display', 'none'); 
                $(parent).html('');;
                $(parent).html(res.data);
            }, 1000);
        }).catch(err => console.log(err));
    });
    
    // Review Page Notification
    $(document).on('click', '.review-notification', function(e) {
        e.preventDefault();

        $(loader).css('display', 'block');
        
        const parent = $('#container_notification');
        axios.get('/account/freelancer/notifications/reviews')
        .then(res => {
            setTimeout(() => {
                $(loader).css('display', 'none');
                $(parent).html('');;
                $(parent).html(res.data);
            }, 1000);
        }).catch(err => console.log(err));
    });
    
    // Read Page Notification
    $(document).on('click', '#read-notification', function(e) {
        e.preventDefault();

        $(loader).css('display', 'block');
        
        const parent = $('#container_notification');
        axios.get('/account/freelancer/notifications/read')
        .then(res => {
            setTimeout(() => {
                $(loader).css('display', 'none');
                $(parent).html('');;
                $(parent).html(res.data);
            }, 1000);
        }).catch(err => console.log(err));
    });
    
    // Unread Page Notification
    $(document).on('click', '#unread-notification', function(e) {
        e.preventDefault();

        $(loader).css('display', 'block');
        
        const parent = $('#container_notification');
        axios.get('/account/freelancer/notifications/unread')
        .then(res => {
            setTimeout(() => {
                $(loader).css('display', 'none');
                $(parent).html('');;
                $(parent).html(res.data);
            }, 1000);
        }).catch(err => console.log(err));
    });

    // Services Page

    // change service page [all, active, archive]
    $(document).on('click', '.service-link', function(e) {
        e.preventDefault();

        $(loader).css('display', 'block');
        $('.service-link').removeClass('active');
        $(this).addClass('active');
        
        const url = $(this).data('service-link');
        const container = $('#parent-show-services');
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'html',
            success: function(res) {
                history.pushState(null, null, url);
                setTimeout(() => {
                    $(container).html('');
                    $(loader).css('display', 'none');
                    $(container).html(res);
                    document.getElementById('select-all-services').checked = false;
                }, 1000);
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

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-sm px-3 py-2 btn-primary',
            },
            buttonsStyling: false
        })

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

        $(loader).css('display', 'block');
        let url = $(this).data('order-link');
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
                    $(loader).css('display', 'none');
                    $(container).html(res);
                }, 1000);
            }
        });
    });

    // Approve Order Btn 
    $('.approve-btn').each(function(index, value) {
        $(value).on('click', function(e) {
            e.preventDefault();

            let orderId = ($(value).siblings('#order_id'))[0].value;

            $.ajax({
                url: `/account/freelancer/orders/approve/${orderId}`,
                method: 'POST',
                success: function(res) {
                    // console.log(res);
                }
            });
        });
    });
    
    // Create & Update

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
        parent.id = 'serviceImage'
        $(parent).css({ "height": "180px", "width": "250px", "overflow": "hidden" });

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
                // value images
                // const icon4 = document.createElement('input');
                // icon4.type = "hidden";
                // icon4.name = 'oldImages[]';
                // icon4.value = event.target.value;
                // parent.appendChild(icon4);

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

        const icon2 = document.createElement('i');
        icon2.className = 'fa-solid fa-xmark text-light p-1 position-absolute d-none';
        $(icon2).css({ 'font-size': '13px', 'top': '0', 'right': '0' });

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
        
        // Remove container add images
        $(icon3).click(function(e) {
            e.preventDefault();

            const parent = $(this).parent();
            $(parent).remove();

            const imgLength = $('.serviceImages').length;
            $('#lengthImg').html('');
            $('#lengthImg').html(imgLength + 1);

            if (imgLength <= 14) {
                $('#addImage').removeClass('d-none');
            }

            updateScroll();
        });

        // add image length
        const addImgLength = $('.serviceImages').length;
        const countElement = document.getElementById('lengthImg');

        // if (parseInt(countElement.textContent) > 1) {
            // const calcUpdate = parseInt(countElement.textContent) + addImgLength;
            // $(countElement).html('');
            // $(countElement).html(calcUpdate);
        // } else {
            const calcAdd = addImgLength + 1;
            $(countElement).html(calcAdd);
        // }

        if (addImgLength >= 14) {
            $(this).addClass('d-none');
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
    $(event).prev().remove();
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
        $(loader).css('display', 'block');
    }

    axios.get('/account/freelancer/services/search', { params: { keyword } })
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).css('display', 'none');
            $(parent).html('');
            $(parent).html(data);
        }, 2000);
    });
}

// Filter SortBy Desc Service
function sortByOldest(event) {
    $(loader).css('display', 'block');
    axios.get('/account/freelancer/services/sort-by-oldest')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).css('display', 'none');
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    });
}

// Filter SortBy Desc Service
function sortByTopOrder(event) {
    $(loader).css('display', 'block');
    axios.get('/account/freelancer/services/sort-by-top-order')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).css('display', 'none');
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    });
}

// Filter SortBy Desc Rating
function sortByTopRating(event) {
    $(loader).css('display', 'block');
    axios.get('/account/freelancer/services/sort-by-top-rating')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).css('display', 'none');
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    }).catch(err => console.error(err.message));
}

// Filter Price Desc
function priceRangeTop(event) {
    $(loader).css('display', 'block');

    event.removeAttribute('onclick');
    event.setAttribute('onclick', 'return priceRangeDown(this)');

    const filter_icon = event.childNodes[3].childNodes[1];
    filter_icon.classList.remove('mdi-unfold-more-horizontal');
    filter_icon.classList.add('mdi-menu-down');
    
    axios.get('/account/freelancer/services/sort-by-high-price')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).css('display', 'none');
            $(parent).html('');
            $(parent).html(data);
        }, 1300);

    }).catch(function(error) {
        console.error(error.message);
    });
}

// Filter Price Asc
function priceRangeDown(event) {
    $(loader).css('display', 'block');

    event.removeAttribute('onclick');
    event.setAttribute('onclick', 'return priceRange(this)');

    const filter_icon = event.childNodes[3].childNodes[1];
    filter_icon.classList.remove('mdi-unfold-more-horizontal');
    filter_icon.classList.add('mdi-menu-up');
    
    axios.get('/account/freelancer/services/sort-by-low-price')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).css('display', 'none');
            $(parent).html('');
            $(parent).html(data);
        }, 1300);
    }).catch(function(error) {
        console.error(error.message);
    });
}

// Filter Price Normal
function priceRange(event) {
    $(loader).css('display', 'block');
    
    event.removeAttribute('onclick');
    event.setAttribute('onclick', 'return priceRangeTop(this)');
    
    const filter_icon = event.childNodes[3].childNodes[1];
    filter_icon.classList.remove('mdi-menu-up');
    filter_icon.classList.add('mdi-unfold-more-horizontal');
    
    axios.get('/account/freelancer/services/sort-by-normal-price')
    .then(function(res) {
        const data = res.data;
        setTimeout(() => {
            $(loader).css('display', 'none');
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
    checkServices.forEach(element => {
        if (element.checked) {
            selectedItems.push(element.nextElementSibling.value);
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

// Archive Selected Services
function archiveSelectedItems() {
    const checkServices = document.querySelectorAll('#select-services');

    var selectedItems = [];
    checkServices.forEach(element => {
        if (element.checked) {
            selectedItems.push(element.nextElementSibling.value);
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

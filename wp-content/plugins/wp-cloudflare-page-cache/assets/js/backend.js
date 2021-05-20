"use strict"

function handle_conditional_settings( mainOption ) {
  // Check if the checked option has value > 0 i.e. YES || Enable selected
  if( parseInt( mainOption.value ) > 0 ) {
    // True value is selected
    // Show the items with the class name present in `data-mainoption`
    if( document.querySelectorAll(`.${mainOption.dataset.mainoption}`).length > 0 ) {
      document.querySelectorAll(`.${mainOption.dataset.mainoption}`).forEach( (item) => {
        if( item.classList.contains('swcfpc_hide') ) {
          item.classList.remove('swcfpc_hide')
        }
      } )
    }

    // Hide all the options that should be hidden when the main option is TRUE
    // i.e. Hide all items with `data-mainoption_not` in them
    if( document.querySelectorAll(`.${mainOption.dataset.mainoption}_not`).length > 0 ) {
      // Loop through the items and show all the other settings are should be shown when the main item is not enabled
      document.querySelectorAll(`.${mainOption.dataset.mainoption}_not`).forEach( (item) => {
        item.classList.add('swcfpc_hide')
      } )
    }

  } else { // FALSE value is selected
    // Hide the items with class name = `data-mainoption`
    if( document.querySelectorAll(`.${mainOption.dataset.mainoption}`).length > 0 ) {
      document.querySelectorAll(`.${mainOption.dataset.mainoption}`).forEach( (item) => {
        item.classList.add('swcfpc_hide')
      } )
    }

    // Show the items with class = `data-mainoption_not`
    if( document.querySelectorAll(`.${mainOption.dataset.mainoption}_not`).length > 0 ) {
      document.querySelectorAll(`.${mainOption.dataset.mainoption}_not`).forEach( (item) => {
        if( item.classList.contains('swcfpc_hide') ) {
          item.classList.remove('swcfpc_hide')
        }
      } )
    }
  }
}


function swcfpc_lock_screen() {
  if ( !document.querySelector('.swcfpc_please_wait') ) {
    const inputTypeSubmit = document.querySelectorAll('input[type=submit]')
    const inputTypeBtn = document.querySelectorAll('input[type=submit]')
    const anchorTags = document.querySelectorAll('a')

    inputTypeSubmit.forEach((item) => {
      item.classList.add('swcfpc_hide')
    })

    inputTypeBtn.forEach((item) => {
      item.classList.add('swcfpc_hide')
    })

    anchorTags.forEach((item) => {
      item.classList.add('swcfpc_hide')
    })

    const waitDiv = document.createElement('div')
    waitDiv.classList.add('swcfpc_please_wait')
    document.body.prepend(waitDiv)
  }
}

function swcfpc_unlock_screen() {
  const inputTypeSubmit = document.querySelectorAll('input[type=submit]')
  const inputTypeBtn = document.querySelectorAll('input[type=submit]')
  const anchorTags = document.querySelectorAll('a')

  inputTypeSubmit.forEach((item) => {
    item.classList.remove('swcfpc_hide')
  })

  inputTypeBtn.forEach((item) => {
    item.classList.remove('swcfpc_hide')
  })

  anchorTags.forEach((item) => {
    item.classList.remove('swcfpc_hide')
  })

  document.querySelector('.swcfpc_please_wait').remove()
}


function swcfpc_redirect_to_page(url) {
  window.location = url
}


function swcfpc_refresh_page() {
  location.reload()
}

function swcfpc_display_ok_dialog(title, content, width, height, type, subtitle, button_name, callback, callback_first_parameter) {

  width = (typeof width === "undefined" || width == null) ? 350 : parseInt(width)
  height = (typeof height === "undefined" || height == null) ? 300 : parseInt(height)
  type = (typeof type === "undefined") ? null : type
  subtitle = (typeof subtitle === "undefined") ? null : subtitle
  button_name = (typeof button_name === "undefined") ? "Close" : button_name
  callback = (typeof callback === "undefined") ? null : callback
  callback_first_parameter = (typeof callback_first_parameter === "undefined") ? null : callback_first_parameter

  let html = '<div id="swcfpc_dialog_container">'

  if (type === "warning")
    html += '<div id="swcfpc_subtitle" class="swcfpc_warning"><br/>'
  else if (type === "error")
    html += '<div id="swcfpc_subtitle" class="swcfpc_error"><br/>'
  else if (type === "info")
    html += '<div id="swcfpc_subtitle" class="swcfpc_info"><br/>'
  else if (type === "success")
    html += '<div id="swcfpc_subtitle" class="swcfpc_success"><br/>'


  if (subtitle !== null)
    html += subtitle;

  if (type != null)
    html += "</div>";

  html += `<div id='swcfpc_dialog_msg_wrapper'>${content}</div>`

  html += "</div>";

  jQuery(html).dialog({
    height: height,
    width: width,
    modal: true,
    title: title,
    buttons: [
      {
        html: button_name,
        click: function () {

          if (callback != null) {

            if (callback_first_parameter != null) {
              callback(callback_first_parameter)
            }
            else {
              callback()
            }

          }
          jQuery(this).dialog('destroy').remove()

        }
      }
    ]
  })
}

async function swcfpc_purge_varnish_cache() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText

    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_purge_varnish_cache&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success")
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}

async function swcfpc_purge_fallback_page_cache() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_purge_fallback_page_cache&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success")
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}

async function swcfpc_purge_whole_cache() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_purge_whole_cache&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success")
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_import_config_file(config_file) {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    const dataJSON = encodeURIComponent( JSON.stringify( {
      "config_file" : config_file
    } ) )

    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_import_config_file&security=${ajax_nonce}&data=${dataJSON}`,
      credentials: 'same-origin'
    } )


    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if(data.status === 'ok') {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success", null, "Ok", swcfpc_refresh_page)
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_purge_single_post_cache(post_id) {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    const dataJSON = encodeURIComponent( JSON.stringify( {
      "post_id" : post_id
    } ) )

    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_purge_whole_cache&security=${ajax_nonce}&data=${dataJSON}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if(data.status === 'ok') {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success")
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_test_page_cache() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_test_page_cache&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success")
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_enable_page_cache() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_enable_page_cache&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success", null, "Ok", swcfpc_refresh_page)
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_disable_page_cache() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_disable_page_cache&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success", null, "Ok", swcfpc_refresh_page)
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_reset_all() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_reset_all&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()

      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success", null, "Ok", swcfpc_refresh_page)
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_clear_logs() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_clear_logs&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()
      
      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success")
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_start_preloader() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_preloader_start&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()
      
      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success")
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}


async function swcfpc_unlock_preloader() {
  try {
    const ajax_nonce = document.getElementById('swcfpc-ajax-nonce').innerText
    swcfpc_lock_screen()

    const response = await fetch( swcfpc_ajax_url,  {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
      },
      body: `action=swcfpc_preloader_unlock&security=${ajax_nonce}`,
      credentials: 'same-origin'
    } )

    
    if(response.ok) {
      const data = await response.json()
      swcfpc_unlock_screen()
      
      if( data.status === 'ok' ) {
        swcfpc_display_ok_dialog("Success", `<div class="swcfpc_dialog_box_msg_wrapper">${data.success_msg}</div>`, null, null, "success")
      } else {
        swcfpc_display_ok_dialog("Error", `<div class="swcfpc_dialog_box_msg_wrapper">${data.error}</div>`, null, null, "error")
      }
    } else {
      console.error(`Error: ${response.status} ${response.statusText}`)
      swcfpc_unlock_screen()
    }
  } catch (err) {
    alert( `Error: ${err.status} ${err.message}` )
    console.error(err)
    swcfpc_unlock_screen()
  }
}

if( document.getElementById('swcfpc_clear_logs') ) {
  document.getElementById('swcfpc_clear_logs').addEventListener( 'click', (e) => {
    e.preventDefault()
    swcfpc_clear_logs()
  } )
}

if( document.getElementById('swcfpc_start_preloader') ) {
  document.getElementById('swcfpc_start_preloader').addEventListener( 'click', (e) => {
    e.preventDefault()
    swcfpc_start_preloader()
  } )
}

if( document.getElementById('swcfpc_unlock_preloader') ) {
  document.getElementById('swcfpc_unlock_preloader').addEventListener( 'click', (e) => {
    e.preventDefault()
    swcfpc_unlock_preloader()
  } )
}

if( document.querySelector('#swcfpc_import_config_start') ) {
  document.querySelector('#swcfpc_import_config_start').addEventListener( 'click', (e) => {
    e.preventDefault()
    const config_file = document.querySelector('#swcfpc_import_config_content').value
    swcfpc_import_config_file(config_file)
  } )
}

if( document.getElementById('swcfpc_fallback_page_cache_purge') ) {
  document.getElementById('swcfpc_fallback_page_cache_purge').addEventListener( 'click', (e) => {
    e.preventDefault()
    swcfpc_purge_fallback_page_cache()
  } )
}

if( document.querySelector('#wp-admin-bar-wp-cloudflare-super-page-cache-toolbar-purge-all a') ) {
  document.querySelector('#wp-admin-bar-wp-cloudflare-super-page-cache-toolbar-purge-all a').addEventListener('click', (e) => {
    e.preventDefault()
    swcfpc_purge_whole_cache()
  } )
}

if( document.querySelector('#wp-admin-bar-wp-cloudflare-super-page-cache-toolbar-purge-single a') ) {
  document.querySelector('#wp-admin-bar-wp-cloudflare-super-page-cache-toolbar-purge-single a').addEventListener( 'click', (e) => {
    e.preventDefault()
    const post_id = e.target.hash.replace('#', '')
    swcfpc_purge_single_post_cache(post_id)
  } )
}

if( document.querySelector('.swcfpc_action_row_single_post_cache_purge') ) {
  document.querySelectorAll('.swcfpc_action_row_single_post_cache_purge').forEach( (item) => {
    item.addEventListener( 'click', (e) => {
      e.preventDefault()
      const post_id = e.target.dataset.post_id
      swcfpc_purge_single_post_cache(post_id)
    } )
  } )
}

if( document.getElementById('swcfpc_varnish_cache_purge') ) {
  document.getElementById('swcfpc_varnish_cache_purge').addEventListener('click', (e) => {
    e.preventDefault()
    swcfpc_purge_varnish_cache()
  } )
}

if( document.getElementById('swcfpc_form_purge_cache') ) {
  document.getElementById('swcfpc_form_purge_cache').addEventListener('submit', (e) => {
    e.preventDefault()
    swcfpc_purge_whole_cache()
  } )
}

if( document.getElementById('swcfpc_form_test_cache') ) {
  document.getElementById('swcfpc_form_test_cache').addEventListener('submit', (e) => {
    e.preventDefault()
    swcfpc_test_page_cache()
  })
}

if( document.getElementById('swcfpc_form_enable_cache') ) {
  document.getElementById('swcfpc_form_enable_cache').addEventListener('submit', (e) => {
    e.preventDefault()
    swcfpc_enable_page_cache()
  } )
}

if( document.getElementById('swcfpc_form_disable_cache') ) {
  document.getElementById('swcfpc_form_disable_cache').addEventListener('submit', (e) => {
    e.preventDefault()
    swcfpc_disable_page_cache()
  } )
}

if( document.getElementById('swcfpc_form_reset_all') ) {
  document.getElementById('swcfpc_form_reset_all').addEventListener('submit', (e) => {
    e.preventDefault()
    swcfpc_reset_all()
  } )
}

if( document.querySelector('select[name=swcfpc_cf_auth_mode]') ) {
  document.querySelector('select[name=swcfpc_cf_auth_mode]').addEventListener('change', (e) => {
    e.preventDefault()

    const method = e.target.value

    if( method === '0' ) { // API Key
      document.querySelectorAll('.api_token_method').forEach( (item) => {
        item.classList.add('swcfpc_hide')
      } )
      document.querySelectorAll('.api_key_method').forEach( (item) => {
        item.classList.remove('swcfpc_hide')
      } )
    } else { // API Token
      document.querySelectorAll('.api_token_method').forEach( (item) => {
        item.classList.remove('swcfpc_hide')
      } )
      document.querySelectorAll('.api_key_method').forEach( (item) => {
        item.classList.add('swcfpc_hide')
      } )
    }
  } )
}

/*
 * Handling the Nav Tabs inside settings page
**/
// Checking if selector exists
if( document.querySelector('#swcfpc_tab_links .nav-tab') ) {
  // Fetch all the selectors with same target
  const navTabs = document.querySelectorAll('#swcfpc_tab_links .nav-tab')

  // Start forEach loop on all the nodes selected
  navTabs.forEach( (navItem) => {
    // Add click event listener on all the items
    navItem.addEventListener('click', (e) => {
      e.preventDefault()

      const id = e.target.dataset.tab

      if( typeof id === undefined ) {
        return true
      }

      // Loop again through the selected nodes to remove .nav-tab-active if it exists anywhere
      navTabs.forEach( (navItem) => {
        if( navItem.classList.contains('nav-tab-active') ) {
          navItem.classList.remove('nav-tab-active')
        }
      } )

      // Add .nav-tab-active to the clicked Item
      e.target.classList.add('nav-tab-active')

      // Loop through all items with .swcfpc_tab and if any of those items has .active, remove that
      document.querySelectorAll('.swcfpc_tab').forEach( (item) => {
        if( item.classList.contains('active') ) {
          item.classList.remove('active')
        }
      } )

      // Add .swcfpc_tab to the id selected
      document.getElementById(id).classList.add('active')

      const generalSubmitBtn = document.querySelector('input[name=swcfpc_submit_general]')

      if( id === 'faq' ) {
        generalSubmitBtn.classList.add('swcfpc_hide')
      } else if ( generalSubmitBtn.classList.contains('swcfpc_hide') ) {
        generalSubmitBtn.classList.remove('swcfpc_hide')
      }

      // Add the id value to the hidden input field
      document.querySelector('input[name=swcfpc_tab]').value = id
    } )
  } )
}

document.addEventListener('DOMContentLoaded', (event) => {

  // Handling how the option shows based on selected option
  // Checking if there is any item with .conditional_item to begin with
  if( document.querySelectorAll('.conditional_item').length > 0 ) {
    // Select all the items with .conditional_item & loop through them
    document.querySelectorAll('.conditional_item').forEach( (mainItem) => {
      // Run on first load after DOM is loaded
      // Check if the item is checked as on the loaded event we are only setting style based on the data we got from server
      if( mainItem.checked ) {
        handle_conditional_settings( mainItem )
      }

      // Add click add event listener to each mainItem so in future when a user clicks on them we can handle it accordingly
      mainItem.addEventListener( 'click', (e) => {
        handle_conditional_settings(e.target)
      } )
    } )
  }

  if ( document.querySelector('.swcfpc_faq_accordion') ) {
    jQuery(".swcfpc_faq_accordion").accordion({ header: "h3", collapsible: true, active: false });
  }

  if( document.querySelector('#swcfpc_tab_links .nav-tab-active') ) {
    const active_tab_id = document.querySelector('#swcfpc_tab_links .nav-tab-active').dataset.tab

    if (typeof active_tab_id !== undefined) {
      document.querySelector('input[name=swcfpc_tab]').value = active_tab_id
    }
  }
})
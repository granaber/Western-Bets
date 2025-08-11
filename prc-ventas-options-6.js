let mCal = null
let mCal2 = null


function GenerarClave() {
  clave = ''
  for (i = 1; i <= 5; i++) {
    var aleatorio = Math.floor(Math.random() * 11)
    clave = clave + aleatorio
  }

  $('claveGenerada').innerHTML = clave
}
function ClaveNuevaVentas() {
  var newclave = $('nwclave').value
  if (newclave.length >= 4 && newclave.length <= 7) {
    if (newclave != '') {
      if (newclave == $('re_nwclave').value) {
        source = 'procierre.php'
        new Ajax.Request(source, {
          parameters: { op: 13, usu: $('usuario').lang, pwdnew: newclave },
          method: 'post',
          onComplete: function (transport) {
            var response = transport.responseText.evalJSON(true)

            if (response) {
              mc01pCloseFunction()
              nalert('CONFIRMACION', 'Clave Actualizada ...')
            } else {
              nalert('ERROR', 'INTENTE DE NUEVO ERROR ACTUALIZANDO LA CLAVE!')
              $('nwclave').value = ''
              $('re_nwclave').value = ''
              $('nwclave').focus()
            }
          },
          onFailure: function () {
            alert('No tengo respuesta Comuniquese con el Administrador!')
          }
        })
      } else {
        nalert('ERROR', 'LAS CLAVES NO SON IGUALES (VERIFIQUE)!')
        $('nwclave').value = ''
        $('re_nwclave').value = ''
        $('nwclave').focus()
      }
    } else {
      nalert('ERROR', 'LAS CLAVES NO PUEDE ESTAR EN BLANCO!')
      $('nwclave').value = ''
      $('re_nwclave').value = ''
      $('nwclave').focus()
    }
  } else {
    nalert('ERROR', 'LAS CLAVES DEBE CONTENER MAS DE 4 CARACTERES y HASTA 7!')
    $('nwclave').value = ''
    $('re_nwclave').value = ''
    $('nwclave').focus()
  }
}

function VerificarClaveVentas() {
  var Resultado = false
  var clave = $('clave').value
  if (clave.length >= 3) {
    if (clave != '') {
      source = 'procierre.php'
      new Ajax.Request(source, {
        parameters: { op: 14, usu: $('usuario').lang, pwdnew: clave },
        method: 'post',
        asynchronous: false,
        onComplete: function (transport) {
          var response = transport.responseText.evalJSON(true)
          if (response) {
            Resultado = true
          } else {
            nalert('ERROR', 'CLAVE ERRADA!')
            Resultado = false
          }
        },
        onFailure: function () {
          alert('No tengo respuesta Comuniquese con el Administrador!')
        }
      })
    } else {
      nalert('ERROR', 'LAS CLAVES NO PUEDE ESTAR EN BLANCO!')
      $('clave').value = ''
      $('clave').focus()
    }
  } else {
    nalert('ERROR', 'LAS CLAVES DEBE CONTENER MAS DE 4 CARACTERES y HASTA 7!')
    $('clave').value = ''
    $('clave').focus()
  }
  return Resultado
}
async function handleChangePw() {
  if (VerificarClaveVentas()) {
    mc01pCloseFunction()
    await showFrom('newClave.ventas.php?usu=' + $('usu').lang, 'op46-1')
    $('nwclave').focus()
  }
}

const [toggleOff,toggleON]=['OFF','ON']
function toggleOnOffElement(ele,type){

  if (type===toggleON){
    ele.forEach(function (e) {
      e.classList.remove('d-none')
    })
    return
  }

  ele.forEach(function (e) {
    e.classList.add('d-none')
  })

}

const JWT = ''
function handlePostModule(op) {
  switch (op) {
    case 'op46':
      $('usuario').lang = $('usu').lang
      $('usuario').innerHTML = $('usu').lang
      $('clave').value = ''
      $('clave').focus()
      break
    case 'sp01':
      //// Recarga  ///fmr-method-pay
      const listTextPay = ['#Referencia', 'Correo Emisor', '#Referencia', '#Referencia']
      const selectElementPay = document.querySelector('.fmr-method-pay')
      selectElementPay.addEventListener('change', (event) => {
        const v = event.target.value

        if (Number(v) === 2) {
          const d1 = document.querySelectorAll('.fmr-metho-for-not-tdc')
          toggleOnOffElement(d1,toggleOff)

          const a1 = document.querySelectorAll('.fmr-metho-for-is-tdc')
          toggleOnOffElement(a1,toggleON)

          return
        }

        const a1 = document.querySelectorAll('.fmr-metho-for-not-tdc')
        toggleOnOffElement(a1,toggleON)

        const d1 = document.querySelectorAll('.fmr-metho-for-is-tdc')
        toggleOnOffElement(d1,toggleOff)

    

        $('fmr-text-ref-pay').innerHTML = listTextPay[Number(v) - 3]
        if (v >= 6) {
          document.querySelector('.fmr-bank-div-pay').classList.remove('d-none')
        } else {
          document.querySelector('.fmr-bank-div-pay').classList.add('d-none')
        }
      })

      //// Retira
      const listTextRet = ['Correo', 'User Binance', 'No. Movil', 'Codigo Cuenta']
      const selectElementRet = document.querySelector('.fmr-method-ret')
      selectElementRet.addEventListener('change', (event) => {
        const v = event.target.value
        $('fmr-text-ref-ret').innerHTML = listTextRet[Number(v) - 3]
        if (v >= 5) {
          document.querySelector('.fmr-bank-div-ret').classList.remove('d-none')
          document.querySelector('.fmr-passport-div-ret').classList.remove('d-none')
        } else {
          document.querySelector('.fmr-bank-div-ret').classList.add('d-none')
          document.querySelector('.fmr-passport-div-ret').classList.add('d-none')
        }
      })
      break
    case 'sp03':
      break
    case 'op65':
      $('myTabVerJugada').addEventListener('click', function(e) {
        e.preventDefault()
        if (e.target.tagName === 'A') {
        const a = $('myTabVerJugada')
        a.childNodes.forEach((e) => {
            if (e.nodeName === 'LI') {
                e.children[0].classList.remove("active")
            }
        })
        e.target.classList.add('active')
        const context = e.target.dataset['context']
        const id = `tab-${context}`
        console.log({id})
    
        const idmain = 'main-tab-verjugada'
        const classOver = ["active", "show"];
        $(idmain).childNodes.forEach((e) => {
            if (e.nodeName === 'DIV') {
                e.classList.remove(...classOver)
            }
        })
        $(id).classList.add(...classOver)
      }
    
    })
    break;
  }
}

// const idForm = $('form-settin-polla')
// const dataForm = Object.fromEntries(new window.FormData(idForm))

async function setRegistreRR({ mode, idusutemp, teluser }) {
  const formId = ['', 'form-cashout', 'form-pay']
  try {
    const e = mode
    const idForm = $(formId[e])
    const dataForm = Object.fromEntries(new window.FormData(idForm))
    const data = {
      mode,
      idusutemp,
      ...dataForm,
      monto: Number(dataForm.monto),
      teluser
    }
    const resp = await fetch('set.recarga.retiro.ventas.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${JWT}`
      },
      body: JSON.stringify(data)
    })
    if (resp.ok) {
      const data = await resp.json()
      const { status, voucher } = data
      if (status) {
        alert('Su solicitud fue registrado con el recibo #' + voucher)
        mc01pCloseFunction()
      } else {
        alert('Hubo un error en el registro de su solicitud, intente mas tarde!')
      }
    }
  } catch (error) {
    console.log(error)
    alert('Hubo un error en el envio de la solicitud!')
  }
}

async function setRegistreRRforTDC({ id, teluser }) {
  const items = `Servicio de recarga-`

  const tItems = []
  const monto = document.querySelector('input[name="montTDC"]:checked').value

  if (typeof monto !== 'undefined') {
    const data = {
      idusu: id
    }
    const resp = await fetch('register-snapshot.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${JWT}`
      },
      body: JSON.stringify(data)
    })
    if (resp.ok) {
      tItems.push(`${items}${monto}`)
      const url =`https://westernbets.pro/apipay.php?rq=PAY_RECARD&items=${tItems}&code=${id}`// `http://localhost:5200/apipay.php?rq=PAY_RECARD&items=${tItems}&code=${id}` //
      window.location.replace(url)
    }
    return
  }
  alert('Debe seleccionar el Monto')
}

// async function setRegistreRR({mode,idusutemp,teluser}){
//   const sufix = ['','ret','pay'] //const [RETIRO,RECARGA] = [1,2] // ret,pay
//   try {
//     const e = mode
//     const data = {
//       mode,
//       idusutemp,
//       monto:Number($(`fmr-monto-${sufix[e]}`).value),
//       referencia:$(`fmr-ref-${sufix[e]}`).value,
//       formatpay:$(`fmr-method-${sufix[e]}`).value,
//       typemonto: e === RETIRO?($('fmr-modosaldo-ret').checked?'TOTAL':'MONTO'):'NA',
//       passport:e === RETIRO?$(`fmr-passport-${sufix[e]}`).value:'NA',
//       teluser,
//       idban:$(`fmr-bank-${sufix[e]}`).value
//     }
//     console.log({data})
//     const resp = await fetch("set.recarga.retiro.ventas.php", {
//       method: "POST",
//       headers: {
//         "Content-Type": "application/json",
//         'Authorization': `Bearer ${JWT}`
//       },
//       body: JSON.stringify(data),
//     })
//     if (resp.ok){
//       const data= await resp.json()
//       const {status,voucher} =data
//       if (status){
//         alert('Su solicitud fue registrado con el recibo #'+voucher)
//         mc01pCloseFunction()
//       }else{
//         alert('Hubo un error en el registro de su solicitud, intente mas tarde!')
//       }
//     }
//   } catch (error) {
//       console.log(error)
//       alert('Hubo un error en el envio de la solicitud!')
//   }
// }
async function showFrom(module, op) {
  mCal = null
  const resp = await fetch(module, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${JWT}`
    }
  })
  const html = await resp.text()
  showSpinner()

  mc01pMAlert(html, '', CERRAR, () => {})
  handlePostModule(op)
}
function handleSwicthRecagaRetiro(e) {
  if (e === RECARGA) {
    $('fmr-recarga').classList.add('d-block')
    $('btn-recarga').classList.remove('btn-opacity')

    $('fmr-retiro').classList.remove('d-block')
    $('btn-retiro').classList.add('btn-opacity')
  }
  if (e === RETIRO) {
    $('fmr-recarga').classList.remove('d-block')
    $('btn-recarga').classList.add('btn-opacity')

    $('fmr-retiro').classList.add('d-block')
    $('btn-retiro').classList.remove('btn-opacity')
  }
}

async function callMenuforVentas(op) {
  showSpinner()
  const codeSpecial = [
    { code: 'sp01', modulo: 'recarga.retiro.ventas.php' },
    { code: 'sp02', modulo: 'transacciones.ventas.php' },
    { code: 'sp03', modulo: 'reportesdePV-1.ventas.php' },
    { code: 'sp04', modulo: 'reportesde.resultados.ventas.php' },
    { code: 'sp05', modulo: 'reportesde.resultados.ventas.animalitos.php' },
    { code: 'sp06', modulo: 'reporte.conforme.americanas.php' },
    { code: 'sp07', modulo: 'setting.client.php' }

  ]

  const f = codeSpecial.find((o) => o.code === op)
  if (f) {
    const { modulo } = f
    showFrom(modulo, op)
    return
  }
  try {
    const resp = await fetch('vermenu.ventas.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${JWT}`
      },
      body: JSON.stringify({ idmenu: op })
    })
    if (resp.ok) {
      const data = await resp.json()
      const { src } = data
      const modulo = src.replace(/[']/g, '')
      showFrom(modulo, op)
      console.log(modulo)
    }
  } catch (error) {
    console.log(error)
    showSpinner()
  }
}
function initMenu() {
  // const mainNav = document.getElementById('main-nav')
  const contextArea = document.getElementById('contextArea')
  const iconMenu = document.getElementById('icons-menu-show')
  const antiIconMenu = document.getElementById('anti-icons-menu-show')
  const opensubmenu = document.getElementById('click-toggle')
  const openavatar = document.getElementById('dropdown-user')
  // console.log(1)
  // const dropdowntoggle = document.getElementById('dropdowntoggle')
  // const dropmenu = document.getElementById('drop-menu')

  // // const dropdowntogglemain = document.getElementById('dropdowntoggle-main')

  // contextArea.classList.add('d-none')
  if (openavatar) {
    openavatar.addEventListener('click', function (e) {
      handlerMenuAvatar()
    })
    contextArea.addEventListener('click', function (e) {
      console.log(e)
      const o = e.target.classList
      if (o.contains('menu-link')) {
        const opt = e.target.dataset.menu
        console.log({ opt })
      if (!opt.contains('none')) {
        // dropmenu.classList.remove('d-block')
        if (opt) {
          if (opt === 'close') {
            onexitclient()
          } else {
            callMenuforVentas(opt)
          }
        }
      }
        //// Aqui ejecuto las opciones de menu
      } else {
        const opt_parent = e.target.parentNode.dataset.menu
        console.log({ opt_parent })
        if (opt_parent) {
          if (opt_parent === 'close') {
            onexitclient()
          } else {
            callMenuforVentas(opt_parent)
          }
        }
      }
    })

    iconMenu.addEventListener('click', function (e) {
      // contextArea.classList.toggle('d-none')
      // document.getElementById('tablemenu').classList.toggle('d-none')
      const ct = document.getElementById('content') //layout-menu-expanded -> .div.container (main)
      ct.classList.add('layout-transitioning', 'layout-menu-expanded')
      // const lf = lg.style.left;
      // console.log({lf})
      // lg.style.left='250px';
      // contextArea.classList.toggle('d-none')
    })
    antiIconMenu.addEventListener('click', function (e) {
      const ct = document.getElementById('content') //layout-menu-expanded -> .div.container (main)
      if (ct.classList.contains('layout-menu-expanded')) {
        ct.classList.remove('layout-menu-expanded')
      }
    })
    opensubmenu.addEventListener('click', function (e) {
      const ct = document.getElementById('click-toggle') //layout-menu-expanded -> .div.container (main)
      ct.classList.toggle('open')
    })

    //   dropdowntoggle.addEventListener('click', function(e) {
    //       dropmenu.classList.toggle('d-block')
    //   })
    //   mainNav.addEventListener('mouseout', function(e) {
    //       const [idt, idp] = [e.target.id, e.target.parentElement.id]
    //       if (idt === "" && idp === "") {
    //           dropmenu.classList.remove('d-block')

    //       }
    //   })
    // }
  }
  callVentas()
}
function handlerMenuAvatar() {
  const el = document.querySelectorAll('ul.dropdown-menu.dropdown-menu-end')[0]
  el.classList.toggle('show')
}

function showSpinner() {
  document.querySelector('.from-wait').classList.toggle('d-block')
}
function getListTicket(d) {
  new Ajax.Request('ver_jugadabb-1.ventas.php?fecha=' + d, {
    method: 'get',
    asynchronous: false,
    onComplete: function (transport) {
      var response = transport.responseText
      if (response) {
        document.querySelector('.frm-table-list-ticket').innerHTML = response
      } else {
        alert('No se pudo cargar la información solicitada')
      }
    },
    onFailure: function () {
      alert('No tengo respuesta Comuniquese con el Administrador!')
    }
  })
  getListTicketAnimalitos(d)
  getListTicketAmericana(d)
}

function getListTicketAnimalitos(d) {
  new Ajax.Request('./animalitos/ver_jugadabb-1.ventas.php?fecha=' + d, {
    method: 'get',
    asynchronous: false,
    onComplete: function (transport) {
      var response = transport.responseText
      if (response) {
        document.querySelector('.frm-table-list-ticket-animalitos').innerHTML = response
      } else {
        alert('No se pudo cargar la información solicitada')
      }
    },
    onFailure: function () {
      alert('No tengo respuesta Comuniquese con el Administrador!')
    }
  })
}
function getListTicketAmericana(d) {
  new Ajax.Request('./americanas/ver_jugadadaa-1.php?fecha=' + d, {
    method: 'get',
    asynchronous: false,
    onComplete: function (transport) {
      var response = transport.responseText
      if (response) {
        document.querySelector('.frm-table-list-ticket-americana').innerHTML = response
      } else {
        alert('No se pudo cargar la información solicitada')
      }
    },
    onFailure: function () {
      alert('No tengo respuesta Comuniquese con el Administrador!')
    }
  })
}

function datepickerVentas(obj, id, cb) {
  if (mCal !== null) {
    mCal.show()
    return
  }
  mCal = new dhtmlxCalendarObject(obj)
  mCal.attachEvent('onClick', function (d) {
    const fecha = mCal.getFormatedDate('%d/%c/%Y', d)
    if ($(id).value !== fecha) {
      $(id).value = fecha
      if (cb) {
        cb(fecha)
      }
    }
    mCal.hide()
  })
  mCal.setSkin('dhx_black')
  mCal.loadUserLanguage('es')
  mCal.draw()
}

function datepickerVentas2(obj, id, cb) {
  if (mCal2 !== null) {
    mCal2.show()
    return
  }
  mCal2 = new dhtmlxCalendarObject(obj)
  mCal2.attachEvent('onClick', function (d) {
    const fecha = mCal2.getFormatedDate('%d/%c/%Y', d)
    if ($(id).value !== fecha) {
      $(id).value = fecha
      if (cb) {
        cb(fecha)
      }
    }
    mCal2.hide()
  })
  mCal2.setSkin('dhx_black')
  mCal2.loadUserLanguage('es')
  mCal2.draw()
}

let windowViewTicket
function verTicketDetall(s) {
  const PRINTERVIEW = 'content-ticket-' + s
  const BUTTONSVIEW = 'list-btn-' + s
  formatoticket(s)
  windowViewTicket = createwindow('Serial ' + s, '', '', true, false, true, 'ticker-windows')
  Layout(windowViewTicket, '2H', ['80%', '10%'])
  attachObjectFramer('A', PRINTERVIEW, windowViewTicket)
  const formPrinter = $(PRINTERVIEW)
  formPrinter.classList.remove('d-none')
  attachObjectFramer('B', BUTTONSVIEW, windowViewTicket)
}
function verTicketDetallAnimalito(s,st,usu) {
  const PRINTERVIEW = 'content-ticket-' + s
  const BUTTONSVIEW = 'list-btn-' + s
  ByViewDUKForAnimalitos(s,st,usu)
  windowViewTicket = createwindow('Serial ' + s, '', '', true, false, true, 'ticker-windows')
  Layout(windowViewTicket, '2H', ['80%', '10%'])
  attachObjectFramer('A', PRINTERVIEW, windowViewTicket)
  const formPrinter = $(PRINTERVIEW)
  formPrinter.classList.remove('d-none')
  attachObjectFramer('B', BUTTONSVIEW, windowViewTicket)
}
function verTicketDetallAmericana(s,st,usu) {
  const PRINTERVIEW = 'content-ticket-' + s
  const BUTTONSVIEW = 'list-btn-' + s
  ByViewDUKForAmericanas(s,st,usu)
  windowViewTicket = createwindow('Serial ' + s, '', '', true, false, true, 'ticker-windows')
  Layout(windowViewTicket, '2H', ['80%', '10%'])
  attachObjectFramer('A', PRINTERVIEW, windowViewTicket)
  const formPrinter = $(PRINTERVIEW)
  formPrinter.classList.remove('d-none')
  attachObjectFramer('B', BUTTONSVIEW, windowViewTicket)
}
let windowReportContable
function imprimi_reporte_ventas() {
  const d1 = $('date-fmr-desde-contable').value
  const d2 = $('date-fmr-hasta-contable').value
  const IDREPORTCONTABLE = 'report-contable-client'
  const BUTTONSVIEW = 'list-btn'

  new Ajax.Request('reporteganaciayperdidasPV.ventas.php?d1=' + d1 + '&d2=' + d2, {
    method: 'get',
    asynchronous: false,
    onCreate: function () {
      showSpinner()
    },
    onComplete: function (transport) {
      showSpinner()
      const response = transport.responseText
      if (response) {
        document.querySelector('.frm-report-contable').innerHTML = response
        $(
          'section2'
        ).innerHTML = `<div id="list-btn" class="btn-command-ticket"><button onclick="destrucWindow()" type="button"  class="btn btn-danger btn-sm">Cerrar</button></div>`
      } else {
        alert('No se pudo cargar la información solicitada')
      }
    },
    onFailure: function () {
      showSpinner()
      alert('No tengo respuesta Comuniquese con el Administrador!')
    }
  })

  windowReportContable = createwindow('Reporte Contable', '', '', true, false, true, 'ticker-windows')
  Layout(windowReportContable, '2H', ['80%', '10%'])
  attachObjectFramer('A', IDREPORTCONTABLE, windowReportContable)
  attachObjectFramer('B', BUTTONSVIEW, windowReportContable)
}
function handleReportResutlGame() {
  const d = $('date-fmr-fecha-result').value

  abrir('impresionresultados.ventas.php?d=' + d, 'Reporte de Resultados ', 1, 0, 0, 0, 0, 1, 1, 400, 400, 100, 100, 1)
}
function handleReportResutlAnimalitos() {
  const d = $('date-fmr-fecha-result').value

  abrir('animalitos/Ani_Resultados-1.php?d1=' + d+'&d2='+d, 'Reporte de Resultados ', 1, 0, 0, 0, 0, 1, 1, 400, 400, 100, 100, 1)
}
function onexitclient() {
  location.reload()
}
async function disclaimerRefresh(){
  mCal = null
  const resp = await fetch('Disclaimer.change.mod.php', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${JWT}`
    }
  })
  const html = await resp.text()

  mc01pMAlert(html, '', CERRAR, () => {})

}
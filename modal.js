const [
  IMPRIMIR,
  CERRAR,
  WHATSAPP,
  OPENMODAL,
  CLOSEMODAL,
  ENVIAR,
  BTNCLOSE,
  BTNSEND,
  BTNNO,
  BTNWS,
  BTNIMP,
  BACKWS,
  CLOSEEND,
  BTNACTIVE,
  BTNONLIPRINT
] = [
  'IMPRIMIR',
  'CERRAR',
  'WS',
  'OPEN',
  'CLOSE',
  'ENVIAR',
  'BTNCLOSED',
  'BTNSEND',
  'BTNNO',
  'BTNWHT',
  'BTNIMPRIMIR',
  'BACKWS',
  'CLOSEEND',
  'BTN_NO_ACTIVE',
  'ONLYPRINT'
]

function $$ (classN) {
  return document.getElementsByClassName(classN)[0]
}
function mc01pCloseFunction (cb) {
  const mc01pModal = $$('mc01p_modal')
  mc01pModal.style.display = 'none'
  if (cb) cb()
}
function mc01pCloseFunctionConfirm (cb, option) {
  const mc01pModal = $$('mc01p_modal')
  mc01pModal.style.display = 'none'
  cb(option)
}
function stateModal () {
  return $$('mc01p_modal').style.display === 'block' ? OPENMODAL : CLOSEMODAL
}
function buttonDefault () {
  return $$('mc01p_modal').dataset.default
}
function isButtomExist (button) {
  const existButtom = {
    [BTNCLOSE]: () => typeof $$('mc01p_modal') !== 'undefined',
    [BTNSEND]: () => typeof $$('btnENVIAR') !== 'undefined',
    [BTNNO]: () => typeof $$('mc01p_modal-otherBtn') !== 'undefined',
    [BTNWS]: () => typeof $$('mc01p_modal-whatsapp') !== 'undefined',
    [BTNIMP]: () => typeof $$('btnIMPRIMIR') !== 'undefined',
    [BTNACTIVE]: () => typeof $$('noKey') !== 'undefined'
  }
  return existButtom[button] ? existButtom[button]() : false
}

function mc01pMAlert (texto, titulo, Mode, cb = () => {}) {
  const mc01pModal = $$('mc01p_modal')
  const modalTexto = $$('mc01p_modal-texto')
  const modalTitle = $$('mc01p_modal-title')

  $$('mc01p_modal-footer').innerHTML = '<button class="mc01p_modal-closed">Cerrar</button>'

  mc01pModal.style.display = 'block'
  modalTexto.innerHTML = texto
  modalTitle.innerHTML = titulo
  mc01pModal.dataset.default = Mode

  const initAlertsInstacia = $$('mc01p_modal-closed')
  initAlertsInstacia.addEventListener('click', () => mc01pCloseFunction(cb))

  const initCloseX = $$('mc01p_modal_x')
  initCloseX.addEventListener('click', () => mc01pCloseFunction(cb))
}

function mc01pMForm (bodyHtml, titulo, disableNo, cb = () => {}) {
  const mc01pModal = $$('mc01p_modal')
  const onlyBoxModal = $$('mc01p_modal-content')
  const modalTexto = $$('mc01p_modal-texto')
  const modalTitle = $$('mc01p_modal-title')

  const KeyActiveNo = disableNo ? 'noKey' : ''

  modalTitle.innerHTML = titulo
  modalTexto.innerHTML = bodyHtml
  $$('mc01p_modal-footer').innerHTML = `<div class="footerWhatSapp"><button class="mc01p_modal-btConfirm btnENVIAR">ENVIAR</button> <button class="mc01p_modal-btConfirm mc01p_modal-otherBtn ${KeyActiveNo}">NO</button></div>`

  onlyBoxModal.classList.add('modalWhatSapp')
  mc01pModal.style.display = 'block'
  mc01pModal.dataset.default = ENVIAR
  

  const initAlertsInstacia = $$('mc01p_modal-btConfirm')
  initAlertsInstacia.addEventListener('click', () => {
    mc01pCloseFunctionConfirm(cb, 'SI')
    onlyBoxModal.classList.remove('modalWhatSapp')
  })

  const initAlertsInstacia2 = $$('mc01p_modal-otherBtn')
  initAlertsInstacia2.addEventListener('click', () => {
    mc01pCloseFunctionConfirm(cb, 'NO')
    onlyBoxModal.classList.remove('modalWhatSapp')
  })

  const initAlertsInstaciaEQUIS = $$('mc01p_modal_x')
  initAlertsInstaciaEQUIS.addEventListener('click', () => {
    mc01pCloseFunctionConfirm(cb, 'NO')
    onlyBoxModal.classList.remove('modalWhatSapp')
  })

  return {
    onClose: () => {
      mc01pCloseFunctionConfirm(cb, 'SI')
      onlyBoxModal.classList.remove('modalWhatSapp')
    }
  }
}

function mc01pMConfirm (texto, titulo, BtnDefautlKey, cb = () => {}) {
  const mc01pModal = $$('mc01p_modal')
  const modalTexto = $$('mc01p_modal-texto')
  const modalTitle = $$('mc01p_modal-title')

  // const

  $$('mc01p_modal-footer').innerHTML = '<button class="mc01p_modal-btConfirm">SI</button> <button class="mc01p_modal-btConfirm mc01p_modal-otherBtn">NO</button>'

  mc01pModal.style.display = 'block'
  modalTexto.innerHTML = texto
  modalTitle.innerHTML = titulo
  mc01pModal.dataset.default = BtnDefautlKey
  

  const initAlertsInstacia = $$('mc01p_modal-btConfirm')
  initAlertsInstacia.addEventListener('click', () =>
    mc01pCloseFunctionConfirm(cb, 'SI')
  )
  const initAlertsInstacia2 = $$('mc01p_modal-otherBtn')
  initAlertsInstacia2.addEventListener('click', () =>
    mc01pCloseFunctionConfirm(cb, 'NO')
  )
  const initAlertsInstaciaEQUIS = $$('mc01p_modal_x')
  initAlertsInstaciaEQUIS.addEventListener('click', () => {
    mc01pCloseFunctionConfirm(cb, 'NO')
  })
}



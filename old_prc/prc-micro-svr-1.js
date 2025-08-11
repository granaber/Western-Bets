const configaxion = {
  onDownloadProgress: function (progressEvent) {
    const pogress = Math.floor((progressEvent.loaded * 100) / progressEvent.total)
    $('spniTextLoad').innerHTML = pogress + '%'
  }
}
function waitSpinner() {
  $('tablemenu').innerHTML =
    '<div class="spni-content"> <div class="loading"><p id="spniTextLoad">Espere..</p><span></span></div></div>'
}
async function callMicrfronter(urlmcs) {
  $('tablemenu-odds').innerHTML = ''
  $('menu1').innerHTML = ''
  waitSpinner()
  try {
    const rnduser = getCookie('rndusr')
    const iduset = $('usu').title
    const response = await axios.get(urlmcs, configaxion)
    const { status, data } = response
    if (status === 200) {
      $('menu1').innerHTML = ''
      $('tablemenu').style.display = 'none'
      $('tablemenu').innerHTML = ` <iframe srcdoc=""></iframe>`
      const attIframe = document.getElementsByTagName('iframe')[0]
      attIframe.setAttribute('srcdoc', data)
      $('tablemenu').style.display = ''
    } else {
      $('tablemenu').innerHTML = ''
    }
  } catch (error) {
    $('tablemenu').innerHTML = '(Error) No se pudo llamar el modulo..'
  }
}
async function callSale2s() {
  $('menu1').innerHTML = ''
  waitSpinner()
  try {
    const rnduser = getCookie('rndusr')
    const iduset = $('usu').title
    const response = await axios.get(`https://ventas.verfacil.com:8443/data/${rnduser}-${iduset}`, configaxion)
    const { status, data } = response
    if (status === 200) {
      $('menu1').innerHTML = ''
      $('tablemenu').style.display = 'none'
      $('tablemenu').innerHTML = ` <iframe srcdoc=""></iframe>`
      const attIframe = document.getElementsByTagName('iframe')[0]
      attIframe.setAttribute('srcdoc', data)
      $('tablemenu').style.display = ''
    } else {
      $('tablemenu').innerHTML = ''
    }
  } catch (error) {
    $('tablemenu').innerHTML = '(Error) No se pudo llamar el modulo..'
  }
}

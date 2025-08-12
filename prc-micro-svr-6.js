var tocketAmericana = 'eizah7pie3zeiboa0ies2go8doogiesohRea9jee'
const TEXT_CREDITO = 'credito'
localStorage.setItem('toket_credit', tocketAmericana)
const configaxion = {
  onDownloadProgress: function (progressEvent) {
    const pogress = Math.floor((progressEvent.loaded * 100) / progressEvent.total)
    $('spniTextLoad').innerHTML = pogress + '%'
  }
}

const configaxion_credit = {
  headers: {
    Authorization: 'Bearer ' + tocketAmericana
  },
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

    const configHead = urlmcs.include(TEXT_CREDITO) ? configaxion_credit : configaxion
    const iurlmcs =urlmcs.replace(':idu',iduset)
    
    const response = await iFetch(iurlmcs, configHead)
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

// async function callMicrfronter(urlmcs) {
//   $('tablemenu').innerHTML = ''
//   $('menu1').innerHTML = ''
//   waitSpinner()
//   try {
//     const rnduser = getCookie('rndusr')
//     const iduset = $('usu').title

//     const configHead = urlmcs.include(TEXT_CREDITO) ? configaxion_credit : configaxion
    
//     const iurlmcs =urlmcs.replace(':idu',iduset)

//     const response = await iFetch(iurlmcs, configHead)
//     const { status, data } = response
//     if (status === 200) {
//       $('menu1').innerHTML = ''
//       $('tablemenu').style.display = 'none'
//       $('tablemenu').innerHTML = ` <iframe srcdoc=""></iframe>`
//       const attIframe = document.getElementsByTagName('iframe')[0]
//       attIframe.setAttribute('srcdoc', data)
//       $('tablemenu').style.display = ''
//     } else {
//       $('tablemenu').innerHTML = ''
//     }
//   } catch (error) {
//     $('tablemenu').innerHTML = '(Error) No se pudo llamar el modulo..'
//   }
// }
function handleIsDecimalParlay(){
  const iduset = $('usu').title

  new Ajax.Request("procierre.php?op=36&idusu="+iduset, {
    method: "get",
    onComplete: function (transport) {
      var response = transport.responseText.evalJSON(true);
      if (response){
        $('systemdecimal').checked=true;
      }else{
        $('systemdecimal').checked=false;
      }
    },

    onFailure: function () {
      alert("No tengo respuesta Comuniquese con el Administrador!");
    },
  });
  callSale2s(MODE)  

}

function handleMode(){
  const iduset = $('usu').title

  new Ajax.Request("procierre.php?op=35&idusu="+iduset, {
    method: "get",
    onComplete: function (transport) {
      var response = transport.responseText.evalJSON(true);
      if (response){
        $('darkmode').checked=true;
      }else{
        $('darkmode').checked=false;
      }
    },

    onFailure: function () {
      alert("No tengo respuesta Comuniquese con el Administrador!");
    },
  });
  disclaimerRefresh();

}
function callrefreshsales(){
  handlerMenuAvatar()
  callSale2s(MODE)
  // callSale2sAnimalitos(MODE)
}
async function callSale2s(MODE) {
  $('menu1').innerHTML = ''
  waitSpinner()
  try {
    const URL = MODE === 'DEV' ? 'http://localhost:9001/data' : 'https://ventas.saamqx.net:8443/data'
    const rnduser = getCookie('rndusr')
    const iduset = $('usu').title
    const response = await iFetch(`${URL}/${rnduser}-${iduset}`, configaxion)
    const { status, data } = response
    if (status === 200) {
      $('menu1').innerHTML = ''
      $('tablemenu').style.display = 'none'
      $('tablemenu').innerHTML = ` <iframe id="mcserv" srcdoc="" name="mcserv"></iframe>`
      const attIframe = document.getElementById('mcserv')
      attIframe.setAttribute('srcdoc', data)
      $('tablemenu').style.display = ''
      let loadNew=true
      attIframe.addEventListener('load',function(e){
        if (loadNew){
          loadNew=false
          callCreditBarr(MODE)
        }else{
          loginVentas()//
        }
      })
    } else {
      $('tablemenu').innerHTML = ''
    }
  } catch (error) {
    $('tablemenu').innerHTML = '<div class="container mt-5 text-center "><button onclick="callVentas()" type="button" class="btn btn-primary btn-lg">Reintentar</button></div>'
  }
}


async function callSale2sAnimalitos(MODE) {
  $('menu1').innerHTML = ''
  waitSpinner()
  try {
    const URL = MODE === 'DEV' ? 'http://localhost:3000' : 'https://ventas.saamqx.net:8443/data'
    const rnduser = getCookie('rndusr')
    const iduset = $('usu').title
    const response = await iFetch(`${URL}`, configaxion)
    const { status, data } = response
    if (status === 200) {
      // $('menu1').innerHTML = ''
      $('tablemenu-animalitos').style.display = 'none'
      $('tablemenu-animalitos').innerHTML = ` <iframe id="mcserv2" src=""></iframe>`
      const attIframe = document.getElementById('mcserv2')
      // attIframe.setAttribute('srcdoc', data)
      attIframe.src=data
      $('tablemenu-animalitos').style.display = ''
      // let loadNew=true
      attIframe.addEventListener('load',function(e){
        // if (loadNew){
        //   loadNew=false
        //   callCreditBarr(MODE)
        // }else{
        //   loginVentas()//
        // }
        console.log(e)
      })
    } else {
      $('tablemenu-animalitos').innerHTML = ''
    }
  } catch (error) {
    $('tablemenu-animalitos').innerHTML = '<div class="container mt-5 text-center "><button onclick="callVentas()" type="button" class="btn btn-primary btn-lg">Reintentar</button></div>'
  }
}
// if (idusuario === 'TEST') {
//   loginVentas()
// } else {
//   callCreditBarr(MODE)
// }

async function callCreditBarr(MODE) {
  const configaxion_credit_forbarra = {
    headers: {
      Authorization: 'Bearer ' + tocketAmericana
    }
  }
  const IDC = $('con').title
  if (IDC === 'TEST1') return
  const URL = MODE === 'DEV' ? `http://localhost:3145/barrah` : 'https://credito.betgambler.net:3145/barrah'
  //document.getElementsByTagName("iframe")['mcserv'].contentDocument.body.getElementsByClassName("section-barra-credit-client")[0].innerHTML="Angel2"
  const config_de_maldito= "";//";background: white;width: 100%;padding-top:3px;"
  document.getElementsByTagName("iframe")['mcserv'].contentDocument.body.getElementsByClassName("section-barra-credit-client")[0].innerHTML = ` <iframe id="top-fmr" srcdoc="" style="height:9vh;display:none;border:none${config_de_maldito}" ></iframe>`
  await activeRefressCreditBarr(URL, IDC, configaxion_credit_forbarra)
}
async function activeRefressCreditBarr(URL, IDC, configaxion_credit_forbarra) {
  try {
    const response = await iFetch(`${URL}/${IDC}`, configaxion_credit_forbarra)
    const { status, data } = response
    if (status === 200) {
      const attIframe =document.getElementsByTagName("iframe")['mcserv'].contentDocument.body.getElementsByClassName("section-barra-credit-client")[0].getElementsByTagName('iframe')[0]
      // document.getElementById('top-fmr')
      attIframe.setAttribute('srcdoc', data)
      attIframe.style.display="block"
    } else {
      $('topmenu').innerHTML = ''
    }
  } catch (error) {
    $('topmenu').innerHTML = ''
  }
}
async function iFetch(URL, config) {
  const response = await axios.get(URL, config)
  return response
}

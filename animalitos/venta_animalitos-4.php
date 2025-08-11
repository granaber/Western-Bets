<!-- <link rel="STYLESHEET" type="text/css" href="./ireaxion/ireaxion-1.css"> -->

<section class="ireaxion-input-box">
    <div>
        <label for="ImpNumero" class="ireaxion-input-label">Numero</label>
        <input type="text" id="ImpNumero" class="ireaxion-input" onkeypress=' return permitebbDUK(event,"num");'
            onkeyup=" pressSpecialDUK(event,'ImpMonto',0) " placeholder="Numero" required>
    </div>
    <div>
        <label for="ImpMonto" class="ireaxion-input-label">Monto</label>
        <input type="text" id="ImpMonto" class="ireaxion-input" placeholder="Monto"
            onkeypress=' return permitebbDUK(event,"real");' onkeyup="pressSpecialDUK(event,'Imprimir',1)" required>
    </div>
</section>
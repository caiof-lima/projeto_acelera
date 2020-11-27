<!-- <!DOCTYPE html> -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../src/css/logInOut.css">
    <link rel="stylesheet" href="../src/css/fonts.css">
    <title>logInOut</title>
    <script>
        function trocarOpcoes(tipoAcesso){
            var mLogin = document.getElementById("log");
            var mCadastrar = document.getElementById("cad");
                if(tipoAcesso ===  "Logar"){
                    // var one = document.getElementById("all-one");
                    // var two = document.getElementById("all-two");
                    mLogin.style.display = "block";
                    mCadastrar.style.display = "none";
                } 
                else if(tipoAcesso === "cadastrar"){
                    // var one = document.getElementById("all-one");
                    // var two = document.getElementById("all-two");
                    // one.style.display = "block";
                    // mLogin.style.width = "100px";
                    // mLogin.style.height = "100px";
                    // mLogin.style.borderRadius = "100px";
                    // mLogin.style.transition = ".5s";
                    mLogin.style.display = "none";
                    mCadastrar.style.display = "block";
                    // two.style.display = "block";
                    // mCadastrar.style.transitionDelay = "2s";
                    // two.style.transitionDelay = "2s";
                }
                else{
                    var tipo = document.getElementById("tipo").value;
                    if(tipo ===  "Logar"){
                        mLogin.style.display = "block";
                        mCadastrar.style.display = "none";
                    } 
                    else if(tipo === "cadastrar"){
                        mLogin.style.display = "none";
                        mCadastrar.style.display = "block";
                    }
                }
        }
    </script>
</head>

<body>
    <?php  
        $tipo = '';
        // echo "<script>alert('AFFF ".$_POST['tipo']."')</script>";
        
        if(isset($_POST['tipo'])){
            $tipo = $_POST['tipo'];
            // echo "<script>alert('AFFF ".$_POST['tipo']."')</script>";
        }   
    ?>
    <input id="tipo" type="hidden" value=<?php echo "$tipo";?>>
    <div class="container">
        <div class="modalLogin" id="log">
            <div id="all-one">
                <h1>Logar</h1>
                <hr>
                <form action="Controller/" method="POST">
                    <input class="camp" type="text" name="email" id="emailId" placeholder="email">
                    <input class="camp" type="password" name="senha" id="senhaId" placeholder="senha">
                    <div class="form-check ckbox">
                        <input type="checkbox" class="box" id="boxId">
                        <p class="boxtxt">Manter-me Logado</p>
                    </div>
                    <button type="submit" class="btn btn-enviar">Entrar</button>
                    <div class="footer-modal">
                        <h2 class="semconta">Ainda não tem conta?</h2>
                        <button class="btn-cad" type="button" onclick='trocarOpcoes("cadastrar")''>Cadastra-se</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modalCadastrar" id="cad">
            <div id="all-two">
                <div class="row">
                    <div class="banner col-sm-5">
                        <h1>Seja Bem Vindo ! ! !</h1>
                        <div class="logo">
                            <img src="logotipo" alt="">
                        </div>
                    </div>
                    <div class="account col-sm-7">
                        <h1>Criar Conta</h1>
                        <hr>
                        <input class="camp" type="text" name="nome" id="nomeIdC" placeholder="nome">
                        <input class="camp" type="text" name="email" id="emailIdC" placeholder="email">
                        <input class="camp" type="password" name="senha" id="senhaIdC" placeholder="senha">
                        <button type="submit" class="btn btn-enviar">Entrar</button>
                        <div class="footer-modal">
                            <h2 class="semconta">Ainda não tem conta?</h2>
                            <button class="btn-cad" type="button" onclick='trocarOpcoes("Logar")'>Logar-se</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    // Juntamente com o php, utilizar o input hidden para saber qual tipo de operacoes sera usaro logar ou cadastrar
    trocarOpcoes("asdsd");
</script>
</body>

</html>


<?php
//cadastro necessita de testes
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = trim($_POST['senha']);
if ((!$nome) ||  (!$email) || (!$senha)){

    echo "ERRO: <br /><br />";
    
    if (!$nome){
    
    echo "Nome é requerido.<br />";
    
    }
    
    
    if (!$email){
    
    echo "Email é um campo requerido.<br /><br />";
    
    }
    
    if (!$senha){
    
    echo "senha é requerido.<br /><br />";
    
    }
    
    echo "Preencha os campos abaixo: <br /><br />";
    
    }else{
    
 //checar dados
    
    $sql_email_check = pg_query(
    
    "SELECT COUNT(usuario_id) FROM usuarios WHERE email='{$email}'"
    
    );
    $sql_usuario_check = pg_query(

        "SELECT COUNT(usuario_id) FROM usuarios WHERE email='{$email}'"
        
        );
        
        $eReg = pg_fetch_array($sql_email_check);
        
        $email_check = $eReg[0];

        if ($email_check > 0){
        
        echo "Este email já está sendo utilizado.<br /><br />";
        
        unset($email);
        
        }
        else{
            $sql = pg_query(

                "INSERT INTO usuarios
                (nome, email, senha)
                
                VALUES
                ('$nome', '$email',  '$senha', )")
                
                or die( pg_error()
                
                );
                
                if (!$sql){
                
                echo "Ocorreu um erro ao criar sua conta, entre em contato.";
                
                }else{
                
                $usuario_id = pg_insert_id();

                }
?>

<?php
//login 
session_start(); 

$email = $_POST['email'];
$senha = $_POST['senha'];

if ((!$usuario) || (!$senha)){

echo "Por favor, todos campos devem ser preenchidos! <br /><br />";

}else{

$senha = ($senha);

$sql = pg_query(

"SELECT * FROM usuarios
WHERE email='{$email}'
AND senha='{$senha}'
"
);

$login_check = pg_num_rows($sql);

if ($login_check > 0){

while ($row = pg_fetch_array($sql)){

foreach ($row AS $key => $val){

$$key = stripslashes( $val );

}

$_SESSION['usuario_id'] = $usuario_id;
$_SESSION['nome'] = $nome;
$_SESSION['email'] = $email;

);


}

}
else{

echo "Você não pode logar-se! Este usuário e/ou senha não são válidos!<br />
Por favor tente novamente!<br />";



   }

}

?>
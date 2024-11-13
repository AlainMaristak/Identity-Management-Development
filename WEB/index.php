<?php
$np = 'Login';
include_once('./includes/head.php');
?>
<section class="vh-100 wcBGColor2">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <h3 class="mb-5">Sign in</h3>

                        <form>
                            <!-- Email input -->
                            <div class="form-floating mb-4">
                                <input type="email" id="form2Example1" class="form-control" placeholder="Email address" />
                                <label for="form2Example1">Email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-floating mb-4">
                                <input type="password" id="form2Example2" class="form-control" placeholder="Password" />
                                <label for="form2Example2">Contraseña</label>
                            </div>

                            <!-- 2 column grid layout for inline styling -->
                            <div class="row mb-4">
                                <div class="col d-flex justify-content-center">
                                    <!-- Checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                        <label class="form-check-label" for="form2Example31"> Remember me </label>
                                    </div>
                                </div>

                                <div class="col">
                                    <!-- Simple link -->
                                    <a href="#!">Forgot password?</a>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <button type="button" class="btn btn-primary btn-block mb-4 wcBtnColor3">Sign in</button>

                            <!-- SSO button -->
                            <div class="text-center">
                                <p>or sign in with Single Sign-On:</p>
                                <button type="button" class="btn btn-lg btn-block btn-primary mb-4 wcBtnColor3">
                                    <i class="fas fa-sign-in-alt me-2"></i> Sign in with SSO
                                </button>
                            </div>

                            <!-- Register link -->
                            <div class="text-center">
                                <p>Not a member? <a href="#!">Register</a></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include_once('./includes/footer.php');
?>
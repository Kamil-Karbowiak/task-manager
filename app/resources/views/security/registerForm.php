{{ include("header.php")}}

<div class="container">
	<div id="form-wrapper">
		<h2>Register</h2>
		
		{% if errors is defined %}
			<div class="alert alert-danger">
			{% for error in errors %}
				<p>{{error}}</p>
			{% endfor %}
			</div>
		{% endif %}
		
		<form method="post">
			<div class="form-group row">
				<label for="email" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" name="email" placeholder="Email">
				</div>
			</div>
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" placeholder="Name">
                </div>
            </div>
			<div class="form-group row">
				<label for="Password" class="col-sm-2 col-form-label">Password</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>
			</div>
				<div class="form-group row">
					<div class="offset-sm-2 col-sm-10">
						<input type="submit" class="btn btn-primary" name="submit" value="Sign up">
					</div>
				</div>
		</form>
		<a href="/task-manager/web/security">Zaloguj się</a>
	</div>
</div>

{{ include("footer.php")}}
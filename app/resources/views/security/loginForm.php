{{ include("header.php")}}

<div class="container">
	<div id="form-wrapper">
		<h2>Login</h2>
		
		{% if message is not empty %}
			<div class="alert alert-success">
			<p>{{message}}</p>
			</div>
		{% endif %}
		
		{% if errors is not empty%}
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
				<label for="Password" class="col-sm-2 col-form-label">Password</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>
			</div>
				<div class="form-group row">
					<div class="offset-sm-2 col-sm-10">
						<input type="submit" class="btn btn-primary" name="submit" value="Sign in">
					</div>
				</div>
		</form>
		<a href="/task-manager/web/security/register">Zarejestruj się</a>
	</div>
</div>

{{ include("footer.php")}}
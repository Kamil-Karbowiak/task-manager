{{ include("header.php") }}
{{ include("home/_mainTopBar.php") }}
	<div class="container">
        <div class="form">
            <h3>{{ header }}</h3>
            <hr>
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
            <form method="get">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Task name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{ task.name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description">{{ task.description }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="priority" class="col-sm-2 col-form-label">Priority</label>
                    <div class="col-sm-10">
                        <select name="priority" class="form-control">
                          <option value="low" {% if task.priority == 'low' %} selected {% endif %}>Low</option>
                          <option value="medium" {% if task.priority == 'medium' %} selected {% endif %}>Medium</option>
                          <option value="high" {% if task.priority == 'high' %} selected {% endif %}>High</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dueDate" class="col-sm-2 col-form-label">Due date</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control" name="dueDate"
                        {% if task is defined %}
                            value="{{ task.dueDate|date("Y-m-d\\TH:i") }}">
                        {% else %}
                                value="{{ "now"|date("Y-m-d\\TH:i") }}">
                        {% endif %}
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ task.id }}">
                {% if task is defined %}
                    <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-control">
                          <option value="todo" {% if task.status == 'todo' %} selected {% endif %}>To-do</option>
                          <option value="done" {% if task.status == 'done' %} selected {% endif %}>Done</option>
                        </select>
                    </div>
                </div>
                {% endif %}
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <input type="submit" class="btn btn-primary" name="submit" value="Add">
                    </div>
                </div>
            </form>
        </div>
	</div>
{{ include("footer.php")}}
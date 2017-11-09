<div id="navbarTop">
    <div class="form-inline">
        <div class="form-group navbar-controls">
            <label class="col-form-label-sm" for="itemsPerPage">Display </label>
            <select class="custom-select form-control-sm navbar-select" name="itemsPerPage" id="itemsNb">
                {% for i in 1..20 %}
                <option value="{{ i }}" {% if i == paginate.resultsPerPage %} selected {% endif %}>{{ i }}</option>
                {% endfor %}
            </select>
        </div>
        <div class="form-group navbar-controls">
            <label class="col-form-label-sm" for="taskStatus">Status </label>
            <select class="custom-select form-control-sm navbar-select" name="tasksStatus">
                <option value="all" {% if(status == 'all') %} selected {% endif %}>All</option>
                <option value="todo" {% if(status == 'todo') %} selected {% endif %}>To do</option>
                <option value="completed" {% if(status == 'completed') %} selected {% endif %}>Completed</option>
            </select>
        </div>
    </div>
</div>

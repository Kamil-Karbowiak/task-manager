{{ include("header.php") }}
{{ include("home/_mainTopBar.php") }}
{{ include("home/_navBarTop.php") }}
<div class="container">
    {% if message is not empty %}
			<div class="alert alert-success">
			<p>{{message}}</p>
			</div>
	{% endif %}
    {% if taskHeader is defined %}
        <h4>{{ taskHeader }}</h4>
    {% endif %}
        <table class="table">
          <thead class="table-info">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Description</th>
              <th>Priority</th>
              <th>Due date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
                {% for task in paginate.items %}
                    {% if task.priority == 'medium' %}
                    <tr class="row-warning">
                    {% elseif task.priority == 'high' %}
                    <tr class="row-danger">
                    {% else %}
                    <tr>
                {% endif %}
                        <td>{{ paginate.firstItemNr + loop.index -1 }}</td>
                        <td>{{ task.name }}</td>
                        <td>{{ task.description }}</td>
                        <td>{{ task.priority }}</td>
                        <td>{{ task.dueDate }}</td>
                        <td>{{ task.status }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                {% if task.status != 'done' %}
                                    <form method="post" action="/task-manager/web/home/done?page={{ paginate.currentPage }}&itemsPerPage={{ paginate.resultsPerPage }}&tasksStatus={{ status }}">
                                        <input type="hidden" name="taskId" value="{{ task.id }}">
                                        <input type="hidden" name="csrfToken" value="{{  csrfToken }}">
                                        <input type="submit" class="btn btn-success" value="Done">
                                    </form>
                                {% endif %}
                                <form method="post" action="/task-manager/web/home/edit">
                                    <input type="hidden" name="taskId" value="{{ task.id }}">
                                    <input type="hidden" name="csrfToken" value="{{  csrfToken }}">
                                    <input type="submit" class="btn btn-warning" value="Edit">
                                </form>
                                <form method="post" action="/task-manager/web/home/delete?page={{ paginate.currentPage }}&itemsPerPage={{ paginate.resultsPerPage }}&tasksStatus={{ status }}">
                                    <input type="hidden" name="taskId" value="{{ task.id }}">
                                    <input type="hidden" name="csrfToken" value="{{  csrfToken }}">
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>
                            </div>
                        </td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
    <div class="text-xs-center">
	  <ul class="pagination">
      {% if paginate.pagesCount > 1 %}
		  {% if paginate.currentPage > 1 %}
			<li class="page-item">
			  <a class="page-link" href="home?page={{ paginate.currentPage-1 }}&itemsPerPage={{ paginate.resultsPerPage }}&tasksStatus={{ status }}" tabindex="-1">Previous</a>
			</li>
		  {% endif %}
		{% for pageNr in 1..paginate.pagesCount%}
			{% if paginate.currentPage == pageNr %}
				<li class="page-item active">
					<a class="page-link" href="home?page={{ pageNr }}&itemsPerPage={{ paginate.resultsPerPage }}&tasksStatus={{ status }}">{{ pageNr }}<span class="sr-only">(current)</span></a>
				</li>
			{% else %}
				<li class="page-item"><a class="page-link" href="home?page={{ pageNr }}&itemsPerPage={{ paginate.resultsPerPage }}&tasksStatus={{ status }}">{{ pageNr }}</a></li>
			{% endif %}
		{% endfor %}
			{% if paginate.currentPage < paginate.pagesCount %}
				<li class="page-item">
				  <a class="page-link" href="home?page={{ paginate.currentPage+1 }}&itemsPerPage={{ paginate.resultsPerPage }}&tasksStatus={{ status }}">Next</a>
				</li>
			{% endif %}
		{% endif %}
	  </ul>
	</div>
</div>
{{ include("footer.php")}}
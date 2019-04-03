<nav class="navbar navbar-default">
	<div class="container-fluid">
        <div class="navbar-header">

            <!-- toggle -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>


		<div class="collapse navbar-collapse" id="top-nav">

			<ul class="nav navbar-nav">

				<!-- マスタ -->
				<li class="dropdown <?= in_array(strtolower($this->name), array("users", "cramschools", "cramschoolclasses")) ? 'active' : '' ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">マスタ機能 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="<?= strtolower($this->name) == "users" ? 'active' : '' ?>"><a href="<?= $this->Url->build(["controller" => "users", "action" => "index"], true); ?>">ユーザーマスタ</a></li>
						<li class="<?= strtolower($this->name) == "cramschools" ? 'active' : '' ?>"><a href="<?= $this->Url->build(["controller" => "cramSchools", "action" => "index"], true); ?>">塾マスタ</a></li>
						<li class="<?= strtolower($this->name) == "cramschoolclasses" ? 'active' : '' ?>"><a href="<?= $this->Url->build(["controller" => "cramSchoolClasses", "action" => "index"], true); ?>">クラスマスタ</a></li>
					</ul>
				</li>

			</ul>
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</nav>

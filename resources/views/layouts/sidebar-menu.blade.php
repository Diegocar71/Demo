<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">

          <i class="nav-icon fa fa-home green" aria-hidden="true" ></i>

          <p>
            Inicio
          </p>
        </router-link>
      </li>

      {{--  <li class="nav-item">
        <router-link to="/products" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>
            Product
          </p>
        </router-link>
      </li>  --}}

      <li class="nav-item">
        <router-link to="/personal" class="nav-link">
          <i class="nav-icon fas fa-user-shield yellow"></i>
          <p>
            Personal
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/sancione" class="nav-link">
          <i class="nav-icon fas fa-chalkboard-teacher purple"></i>
          <p>
            Sanciones
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/felicitaciones" class="nav-link">
          <i class="nav-icon fas fa-hands-helping blue"></i>
          <p>
            Felicitaciones
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/calificaciones" class="nav-link">
          <i class="nav-icon far fa-edit orange"></i>
          <p>
            Calificaciones
          </p>
        </router-link>
      </li>

      @can('isAdmin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Usuarios</p>
          </router-link>
        </li>
      @endcan

      {{--  @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Category
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                Tags
              </p>
            </router-link>
          </li>

            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li>
        </ul>
      </li>

      @endcan  --}}



      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Cerrar Sesion') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>

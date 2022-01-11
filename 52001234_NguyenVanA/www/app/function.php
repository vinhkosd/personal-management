<?php
function homePath($isReturn = false) {
	$selfPath = substr($_SERVER['PHP_SELF'], 1);
  $path = substr($_SERVER['REQUEST_URI'], 1);//remove / slash
  $countSlash = substr_count($path,"/") - substr_count($selfPath,"/");
  if($isReturn) return str_repeat("../", $countSlash);
  echo str_repeat("../", $countSlash);
}

function realFilePath() {
	$selfPath = substr($_SERVER['PHP_SELF'], 1);
  $path = substr($_SERVER['REQUEST_URI'], 1);//remove / slash
  $countSlash = substr_count($selfPath,"/") ;
  return str_repeat("../", $countSlash);
}
function repeatSlash() {
	$selfPath = substr($_SERVER['PHP_SELF'], 1);
  $path = substr($_SERVER['REQUEST_URI'], 1);//remove / slash
  $countSlash = substr_count($path,"/") - substr_count($selfPath,"/") ;
  return str_repeat("../", $countSlash > 0 ? $countSlash - 1 : 0);
}

function validateLogin($isDie = false, $dieOnAuthenticated = false) {
  if(isset($_SESSION['username'])) {

    if($isDie && $dieOnAuthenticated)
      die('<script type="text/javascript">
      window.location = "'.homePath(true).'";
      </script>');
    return true;
  }
  if($isDie && !$dieOnAuthenticated)
  die('<script type="text/javascript">
    window.location = "'.homePath(true).'";
    </script>');
  return false;
}

function renderBody() {
  if(isset($_SESSION['username'])) {
    include(__DIR__."/../pages/accountsidebar.php");
  }
  $path = !empty($_GET['page']) ? $_GET['page'] : '';//remove / slash
  $path = parse_url($path, PHP_URL_PATH);//only get url path
  if($path && file_exists(__DIR__."/../".realFilePath().$path.".php")){
    if(isset($_SESSION['isFirst']) && $_SESSION['isFirst']) {
      $path = $_GET['page'];//remove / slash
      if(strpos($path, "newpassword") === false)
        redirectRoute('pages/account/newpassword');
    }

    include(__DIR__."/../".realFilePath().$path.".php");
  }
  else {
    if(isset($_SESSION['username'])) {
      include(__DIR__."/../pages/home.php");
    } else {
      redirectRoute('pages/auth/login');
    }
  }
  if(isset($_SESSION['username'])) {
    include(__DIR__."/../pages/footer.php");
  }
}

function redirectRoute($url) {
  die('<script type="text/javascript">
  window.location = "'.homePath(true)."?page=".$url.'";
  </script>');
}

function renderNavbar() {
    if(isset($_SESSION['username'])) {
        include(__DIR__."/../pages/navbar.php");
    } 
}

function getPartial($queryData = [], $limit = 100, $page = 1, $columns = [], $typicalOffset = null)
{
    $data = [];
    $offset = $typicalOffset ? $typicalOffset : (($page - 1) * $limit);
    $totalRecord = $queryData->count();

    if ($totalRecord) {
        $totalPage = ($totalRecord % $limit == 0) ? $totalRecord / $limit : ceil($totalRecord / $limit);
        if($limit != -1) {
        $data = $queryData->offset($offset)
            ->limit($limit);
        } else {
            $data = $queryData;
        }
        if ($columns) $data = $data->get($columns);
        else $data = $data->get();
    } else {
        $totalPage = 0;
        $page = 0;
        $totalRecord = 0;
    }
    $dataPartial = array();
    foreach($data as $key => $value) {
        $item = $value;
        $item['DT_RowData'] = json_decode(json_encode($value), true);
        $item['DT_RowId'] = "row_".$key;
        array_push($dataPartial, $item);
    }

    $result = [
        'data'          => $dataPartial,
        'page'          => $page,
        'totalPage'     => $totalPage,
        'totalRecord'   => $totalRecord,
        'totalFiltered' => count($data)
    ];

    return $result;
}

function checkPermission($perm, $isRedirect = false) {
  if(isset($_SESSION['role'])) {
    if($_SESSION['role'] == "god") {
      return true;
    }

    if($_SESSION['role'] == "admin" && $perm != "god") {
      return true;
    }

    if($_SESSION['role'] == $perm) {
      return true;
    }

    if($isRedirect)
      die('<script type="text/javascript">
      window.location = "'.homePath(true).'";
      </script>');

    return false;
  }

  if($isRedirect)
      die('<script type="text/javascript">
      window.location = "'.homePath(true).'";
      </script>');

  return false;
}

function requirePerm($perm) {
  $isDie = true;
  if(isset($_SESSION['role'])) {
    if($_SESSION['role'] == "god") {
      //do nothing
      $isDie = false;
    }

    if($_SESSION['role'] == "admin" && $perm != "god") {
      //do nothing
      $isDie = false;
    }

    if($_SESSION['role'] == $perm) {
      //do nothing
      $isDie = false;
    }

    if($isDie)
      die();
  }

  if($isDie)
      die();
}

function calculateImageUrl() {
  if(isset($_SESSION['imageurl'])) {
    $imageUrl = $_SESSION['imageurl'];
    if(strpos($imageUrl, "http") === false) {// khong co duong dan
      $imageUrl = homePath(true).$imageUrl;
    }
    return $imageUrl;
  } 
  return "";
}
?>
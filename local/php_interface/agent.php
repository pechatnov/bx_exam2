<?
function CheckUserCount(){

    $lastTime = new DateTime(COption::GetOptionString('main', 'LAST_CHECK_USER_TIME'));
    COption::SetOptionString('main', 'LAST_CHECK_USER_TIME', date('Y-m-d'));

    $diffDays = $lastTime->diff(new DateTime());
    $diffDays = $diffDays->format('%a');

    $arUsers = [];
    $start = strtotime("-$diffDays day");
    $stop = strtotime("today");

    $filter = [
        'DATE_REGISTER_1' => date('d.m.Y. H:i:s', $start),
        'DATE_REGISTER_2' => date('d.m.Y. H:i:s', $stop)
    ];
    $ob = CUser::GetList($by = false, $order = false, $filter);
    while ($res = $ob->GetNext()) {
        $arUsers[] = $res['ID'];
    }

    $arEmail = [];
    $filter = ["GROUPS_ID" => [USER_ADMIN_GROUP]];
    $ob = CUser::GetList($by = false, $order = false, $filter);
    while ($res = $ob->GetNext()) {
        $arEmail[] = $res['EMAIL'];
    }

    CEvent::Send(
        "CHECK_USERS_REG",
        SITE_ID,
        [
            'COUNT' => count($arUsers),
            'DAYS' => $diffDays,
            'EMAIL' => implode(",", $arEmail),
        ]
    );

    return "CheckUserCount();";
}
if (window.applicationCache) {
    window.applicationCache.addEventListener('updateready', function (e) {
        if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
            applicationCache.swapCache()
            window.location.reload();
        } else {
            // Manifest娌℃湁鏀瑰姩锛宯othing to do 
        }
    }, false);

    // 閿欒澶勭悊
    window.applicationCache.addEventListener('error', function (e) {
        // nothing to do 
        return false;
    }, false);
}
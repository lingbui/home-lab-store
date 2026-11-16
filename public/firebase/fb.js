/*
 * Cấu hình Firebase cho trang admin (thông báo đơn hàng + chat realtime).
 *
 * Cách bật: Firebase console > Project settings > Your apps > Web app,
 * chép các giá trị vào firebaseConfig bên dưới (bắt buộc có apiKey và databaseURL).
 *
 * Nếu để trống, trang admin vẫn chạy bình thường, chỉ tắt phần realtime
 * (không báo lỗi trong console).
 */
var firebaseConfig = {
    apiKey: "",
    authDomain: "",
    databaseURL: "",
    projectId: "",
    storageBucket: "",
    messagingSenderId: ""
};

(function () {
    if (typeof firebase !== 'undefined' && firebaseConfig.apiKey && firebaseConfig.databaseURL) {
        if (!firebase.apps.length) {
            firebase.initializeApp(firebaseConfig);
        }
        return;
    }

    // Chưa cấu hình: thay bằng object giả để các đoạn script gọi firebase.database() không bị lỗi.
    var noop = function () { return Promise.resolve(null); };
    var ref = { on: function () {}, off: function () {}, once: noop, push: noop, set: noop, update: noop, remove: noop };
    ref.child = function () { return ref; };
    ref.orderByChild = ref.orderByKey = ref.limitToLast = ref.limitToFirst = ref.child;

    window.firebase = {
        apps: [],
        initializeApp: function () {},
        database: function () { return { ref: function () { return ref; } }; }
    };
    console.info('Firebase chưa được cấu hình (public/firebase/fb.js): tắt thông báo/chat realtime.');
})();

var options = {
    data: [
        {"text": "Dashboard", "website-link": "cashierdashboard.php"},
        {"text": "Transaction", "website-link": "purchase.php"},
        {"text": "Reports", "website-link": "reports.php"},
        {"text": "Contacts", "website-link": "contacts.php"},
        {"text": "Products", "website-link": "products.php"},
        {"text": "Membership Register", "website-link": "simscoderegister.php"},
        {"text": "QR Scan", "website-link": "simscodescan.php"},
        {"text": "Account Settings", "website-link": "accountsettings.php"},
    ],

    getValue: "text",

    template: {
        type: "links",
        fields: {
            link: "website-link"
        }
    },
    list: {
        maxNumberOfElements: 5,
        match: {
            enabled: true
        },
        showAnimation: {
			type: "fade", //normal|slide|fade
			time: 400,
			callback: function() {}
		},

		hideAnimation: {
			type: "slide", //normal|slide|fade
			time: 400,
			callback: function() {}
        },
        onChooseEvent: function() {
            let selected=null;
            selected = $(".template-links").getSelectedItemData();
            location.replace(selected["website-link"]);
        }
    },
    theme: "round"
};

$(".template-links").easyAutocomplete(options);
const Menu =  [
        { header: 'Apps' },
        {
            title: 'Dashboard',
            group: 'apps',
            icon: 'dashboard',
            name: 'Dashboard',
        },{
            title: 'Contacts',
            group: 'apps',
            icon: 'perm_identity',
            name: 'Contacts'
        },{
            title: 'Estimations',
            group: 'apps',
            icon: 'view_list',
            name: 'Estimations'
        },{
            title: 'Personnels',
            group: 'apps',
            icon: 'face',
            name: 'Personnels'
        },{
            title: 'Fournisseurs',
            group: 'apps',
            icon: 'shop',
            name: 'Fournisseurs'
        }
    ]

// reorder menu
Menu.forEach((item) => {
    if (item.items) {
        item.items.sort((x, y) => {
            let textA = x.title.toUpperCase();
            let textB = y.title.toUpperCase();
            return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
        });
    }
});

export default Menu;
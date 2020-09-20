describe('List of Content Creators Public Page', () => {

    it('shows a content creator', () => {
        cy.refreshDatabase();
        let creator = {
            name: 'Black Mamba',
            url: 'https://kobe.com',
            notes: 'Says Yoink a lot!',
        }
        cy.create('App\\Models\\Creator', 1, creator);

       cy.visit('/creators').contains(creator.name);
    });

    it('shows multiple content creators', () => {
        cy.refreshDatabase();
        cy.seed('CreatorSeeder');

       cy.visit('/creators');
       cy.contains('Skelturix');
       cy.contains('Wiggensbog');
       cy.contains('https://www.youtube.com/channel/UCuKkFu9WVxCRoj2EbWzIj3Q');
    });


});

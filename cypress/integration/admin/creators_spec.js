describe('Crud on Content Creators', () => {
    it('handles the happy add path', () => {
        cy.refreshDatabase();
        cy.seed('CreatorSeeder');
        cy.login({role: 'admin'});
        cy.visit('/admin/creators');
        cy.contains('Content Creators');
        cy.get('#name')
            .type('New Guy 123')
            .should('have.value', 'New Guy 123');
        cy.get('#url')
          .type('http://abc.com')
          .should('have.value', 'http://abc.com');
        cy.get('#notes')
          .type('Here\'s a little note I wrote...')
          .should('have.value', 'Here\'s a little note I wrote...');
        cy.get('#save-btn').click();
        cy.contains('added!');
    });
    it('shows validation error messages', () => {
        cy.refreshDatabase();
        cy.seed('CreatorSeeder');
        cy.login({role: 'admin'});
        cy.visit('/admin/creators');
        cy.get('#save-btn').click();
        cy.contains('The name field is required.');
    });
    it('edits a existing record', () => {
        cy.refreshDatabase();
        cy.seed('CreatorSeeder');
        cy.login({role: 'admin'});
        cy.visit('/admin/creators');
        cy.get('#edit-0').click();
        cy.get('#name')
            .type('New Guy 456')
        cy.get('#save-btn').click();
        cy.contains('New Guy 456 updated!');
    });
});

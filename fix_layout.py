with open('resources/views/layouts/app.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Fix the broken form tag
content = content.replace(
    '''            </span>

                @csrf''',
    '''            </span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf'''
)

# Fix missing closing divs before page-content
content = content.replace(
    '''        </div>
    <div class="page-content">''',
    '''        </div>
    <div class="page-content">'''
)

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Fixed!')
